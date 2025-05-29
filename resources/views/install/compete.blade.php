@extends('install.layouts')

@section('title', 'Installation Complete - AEVO SMM Installer')

@section('content')
    <div class="step-indicator">
        <div class="step completed">1</div>
        <div class="step completed">2</div>
        <div class="step completed">3</div>
        <div class="step completed">4</div>
    </div>

    <div class="text-center">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
        </div>

        <h1 class="text-success mb-4">Installation Complete!</h1>

        <div class="alert alert-success mb-4">
            <i class="fas fa-party-horn me-2"></i>
            Your AEVO SMM application has been successfully installed and configured.
        </div>

        <div class="row text-start mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            What was completed:
                        </h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-database text-primary me-2"></i>Database configured and migrated</li>
                            <li><i class="fas fa-key text-primary me-2"></i>Application key generated</li>
                            <li><i class="fas fa-cog text-primary me-2"></i>Environment file updated</li>
                            <li><i class="fas fa-cache text-primary me-2"></i>Configuration cached</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-shield-alt text-warning me-2"></i>
                            Security Notes:
                        </h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-lock text-danger me-2"></i>Installer is now disabled</li>
                            <li><i class="fas fa-file-alt text-info me-2"></i>Check your .env file permissions</li>
                            <li><i class="fas fa-server text-success me-2"></i>Configure your web server</li>
                            <li><i class="fas fa-user text-success me-2"></i>Configure your Site settings </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-warning mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Important:</strong> For security reasons, consider removing the installer files from your production
            server.
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a href="{{ route('index') }}" class="btn btn-installer btn-lg me-md-2">
                <i class="fas fa-home me-2"></i>Go to Application
            </a>
            @if (session('installer.admin_created'))
                <a href="{{ route('admin.login') }}" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Login as Admin
                </a>
            @endif
        </div>

        <div class="mt-4">
            <small class="text-muted">
                <i class="fas fa-heart text-danger me-1"></i>
                Thank you for using AEVO SMM application!
            </small>
        </div>
    </div>
@endsection
