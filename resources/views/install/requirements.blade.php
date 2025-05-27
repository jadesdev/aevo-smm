@extends('install.layouts')

@section('title', 'System Requirements - AEVO SMM Installer')

@section('content')
    <div class="step-indicator">
        <div class="step completed">1</div>
        <div class="step active">2</div>
        <div class="step">3</div>
        <div class="step">4</div>
    </div>

    <h2 class="text-center mb-4">
        <i class="fas fa-clipboard-check text-primary me-2"></i>
        System Requirements Check
    </h2>

    <div class="mb-4">
        @php
            $allPassed = true;
            foreach ($requirements as $requirement) {
                if (!$requirement['check']) {
                    $allPassed = false;
                    break;
                }
            }
        @endphp

        @foreach ($requirements as $key => $requirement)
            <div class="requirement-item {{ $requirement['check'] ? 'passed' : 'failed' }}">
                <div>
                    <strong>{{ $requirement['name'] }}</strong>
                    <br>
                    <small class="text-muted">Current: {{ $requirement['current'] }}</small>
                </div>
                <div>
                    @if ($requirement['check'])
                        <i class="fas fa-check-circle text-success fa-lg"></i>
                    @else
                        <i class="fas fa-times-circle text-danger fa-lg"></i>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if ($allPassed)
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            Great! All system requirements are met. You can proceed with the installation.
        </div>
    @else
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Some requirements are not met. Please fix the issues above before proceeding.
        </div>
    @endif

    <div class="d-flex justify-content-between">
        <a href="{{ route('install.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>

        @if ($allPassed)
            <a href="{{ route('install.database') }}" class="btn btn-installer">
                Next <i class="fas fa-arrow-right ms-2"></i>
            </a>
        @else
            <button class="btn btn-installer" disabled>
                Fix Requirements First
            </button>
        @endif
    </div>
@endsection
