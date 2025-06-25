@extends('install.layouts')

@section('title', 'AEVO SMM Installer')

@section('content')
<div class="text-center">
    <div class="step-indicator">
        <div class="step active">1</div>
        <div class="step">2</div>
        <div class="step">3</div>
        <div class="step">4</div>
    </div>

    <i class="fas fa-rocket fa-4x text-primary mb-4"></i>
    <h1 class="mb-4">Welcome to the AEVO SMM Installer</h1>
    <p class="lead mb-4">This installer will guide you through the setup process of your AEVO SMM application.</p>
    
    <div class="alert alert-info mb-4">
        <i class="fas fa-info-circle me-2"></i>
        Please ensure you have your database credentials ready before proceeding.
    </div>

    <div class="row text-start mb-4">
        <div class="col-md-6">
            <h5><i class="fas fa-check-circle text-success me-2"></i>What we'll do:</h5>
            <ul class="list-unstyled ms-4">
                <li><i class="fas fa-cog text-primary me-2"></i>Check system requirements</li>
                <li><i class="fas fa-database text-primary me-2"></i>Configure database</li>
                <li><i class="fas fa-tools text-primary me-2"></i>Set up environment</li>
                <li><i class="fas fa-rocket text-primary me-2"></i>Complete installation</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h5><i class="fas fa-exclamation-triangle text-warning me-2"></i>Requirements:</h5>
            <ul class="list-unstyled ms-4">
                <li><i class="fas fa-server text-primary me-2"></i>PHP 8.2 or higher</li>
                <li><i class="fas fa-database text-primary me-2"></i>MySQL/MariaDB database</li>
                <li><i class="fas fa-folder text-primary me-2"></i>Writable storage directory</li>
                <li><i class="fas fa-key text-primary me-2"></i>Database credentials</li>
            </ul>
        </div>
    </div>

    <a href="{{ route('install.requirement') }}" class="btn btn-installer btn-lg">
        <i class="fas fa-arrow-right me-2"></i>Get Started
    </a>
</div>
@endsection