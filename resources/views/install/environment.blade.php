@extends('install.layouts')

@section('title', 'Final Setup - AEVO SMM Installer')

@section('content')
    <div class="step-indicator">
        <div class="step completed">1</div>
        <div class="step completed">2</div>
        <div class="step completed">3</div>
        <div class="step active">4</div>
    </div>

    <h2 class="text-center mb-4">
        <i class="fas fa-cogs text-primary me-2"></i>
        Final Setup
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif

    @if (Session::get('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ Session::get('error') }}
        </div>
    @endif

    <form action="{{ route('install.settings.save') }}" method="POST" id="installForm">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user-shield me-2"></i>Administrator Account</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="admin_email" class="form-label">Admin Email</label>
                        <input type="email" class="form-control" id="admin_email" name="admin_email" required
                            value="{{ old('admin_email') }}" placeholder="admin@example.com">
                    </div>
                    <div class="col-md-6">
                        <label for="admin_password" class="form-label">Admin Password</label>
                        <input type="password" class="form-control" id="admin_password" name="admin_password" required
                            placeholder="Strong password">
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Ready to install!</strong> This process will:
            <ul class="mb-0 mt-2">
                <li>Configure your environment file</li>
                <li>Setup database </li>
                <li>Set up application cache</li>
                <li>Create storage links</li>
                <li>Mark installation as complete</li>
            </ul>
        </div>

        <div class="d-sm-flex justify-content-between">
            <a href="{{ route('install.database.show') }}" class="btn btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>

            <button type="submit" class="btn btn-installer btn-lg" id="installBtn">
                <i class="fas fa-rocket me-2"></i>Install Application
            </button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        document.getElementById('installForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('installBtn');
            const originalText = btn.innerHTML;

            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Installing...';
            btn.disabled = true;

            // Let the form submit normally, but disable the button to prevent double-clicking
        });
    </script>
@endsection
