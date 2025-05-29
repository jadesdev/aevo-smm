<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CheckTelementry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Skip check for local development
            if ($this->isLocalEnvironment()) {
                return $next($request);
            }

            $authorizedDomains = $this->getAuthorizedDomains();
            $currentDomain = $this->extractDomain($request->getSchemeAndHttpHost());

            if (!$this->isDomainAuthorized($currentDomain, $authorizedDomains)) {
                // $this->logUnauthorizedAccess($request);
                return response()->view('telementry', [
                    'current_domain' => $currentDomain,
                    'current_url' => $request->getSchemeAndHttpHost()
                ], 403);
            }

            return $next($request);
        } catch (\Exception $e) {
            Log::error('Telementry check failed: ' . $e->getMessage());
            return $next($request);
        }
    }

    /**
     * Get authorized domains from storage
     */
    private function getAuthorizedDomains(): array
    {
        $telementryPath = storage_path('telementry');

        if (!File::exists($telementryPath)) {
            return [];
        }

        $content = File::get($telementryPath);

        if (str_contains($content, "\n") || str_contains($content, ',')) {
            $domains = array_filter(array_map('trim', preg_split('/[\n,]/', $content)));
        } else {
            $domains = [$content];
        }

        return array_map([$this, 'extractDomain'], $domains);
    }

    /**
     * Extract domain from URL (removes protocol and normalizes)
     */
    private function extractDomain(string $url): string
    {
        $domain = preg_replace('/^https?:\/\//', '', $url);

        $domain = preg_replace('/:\d+$/', '', $domain);

        $domain = rtrim($domain, '/');
        return strtolower($domain);
    }

    /**
     * Check if current domain is authorized
     */
    private function isDomainAuthorized(string $currentDomain, array $authorizedDomains): bool
    {
        if (empty($authorizedDomains)) {
            return false;
        }

        foreach ($authorizedDomains as $authorizedDomain) {
            $normalizedAuthorized = $this->extractDomain($authorizedDomain);

            // Exact match
            if ($currentDomain === $normalizedAuthorized) {
                return true;
            }

            if (
                str_starts_with($normalizedAuthorized, '.') &&
                str_ends_with($currentDomain, $normalizedAuthorized)
            ) {
                return true;
            }

            if ($this->isWwwVariant($currentDomain, $normalizedAuthorized)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if domains are www variants of each other
     */
    private function isWwwVariant(string $domain1, string $domain2): bool
    {
        $withoutWww1 = preg_replace('/^www\./', '', $domain1);
        $withoutWww2 = preg_replace('/^www\./', '', $domain2);

        return $withoutWww1 === $withoutWww2;
    }

    /**
     * Check if running in local development environment
     */
    private function isLocalEnvironment(): bool
    {
        $host = request()->getHost();

        return app()->environment('local') ||
            in_array($host, ['localhost', '127.0.0.1', '::1']) ||
            str_ends_with($host, '.local') ||
            str_ends_with($host, '.test');
    }

    /**
     * Log unauthorized access attempts
     */
    private function logUnauthorizedAccess(Request $request): void
    {
        $data = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'domain' => $request->getHost(),
            'timestamp' => now()->toISOString(),
        ];

        Log::warning('Unauthorized domain access attempt', $data);

        // Cache recent attempts to prevent spam
        $cacheKey = 'unauthorized_access_' . $request->ip();
        $attempts = Cache::get($cacheKey, 0) ?? 0;
        Cache::put($cacheKey, $attempts + 1, 3600);
    }
}
