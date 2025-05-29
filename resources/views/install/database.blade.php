@extends('install.layouts')

@section('title', 'Database Configuration - AEVO SMM Installer')

@section('content')
    <div class="step-indicator">
        <div class="step completed">1</div>
        <div class="step completed">2</div>
        <div class="step active">3</div>
        <div class="step">4</div>
    </div>

    <h2 class="text-center mb-4">
        <i class="fas fa-database text-primary me-2"></i>
        Database Configuration
    </h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('install.database.save') }}" method="POST" id="databaseForm">
        @csrf

        <div class="col-md-12 mb-3 ">
            <label for="site_url" class="form-label">Site URL</label>
            <input type="url" class="form-control" id="site_url" name="site_url" value="{{ url('/') }}"
                required>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="app_name" class="form-label">Application Name</label>
                <input type="text" class="form-control" id="app_name" name="app_name"
                    value="{{ old('app_name', 'Aevo SMM') }}" required>
            </div>
            <div class="col-md-6">
                <label for="db_host" class="form-label">Database Host</label>
                <input type="text" class="form-control" id="db_host" name="db_host"
                    value="{{ old('db_host', '127.0.0.1') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="db_port" class="form-label">Database Port</label>
                <input type="number" class="form-control" id="db_port" name="db_port"
                    value="{{ old('db_port', '3306') }}" required>
            </div>
            <div class="col-md-6">
                <label for="db_name" class="form-label">Database Name</label>
                <input type="text" class="form-control" id="db_name" name="db_name" value="{{ old('db_name') }}"
                    required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="db_username" class="form-label">Database Username</label>
                <input type="text" class="form-control" id="db_username" name="db_username"
                    value="{{ old('db_username') }}" required>
            </div>
            <div class="col-md-6">
                <label for="db_password" class="form-label">Database Password</label>
                <input type="password" class="form-control" id="db_password" name="db_password"
                    value="{{ old('db_password') }}">
            </div>
        </div>

        <div class="mb-4">
            <button type="button" class="btn btn-outline-primary" id="testConnection">
                <i class="fas fa-plug me-2"></i>Test Database Connection
            </button>
            <div id="connectionResult" class="mt-2"></div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('install.requirement') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>

            <button type="submit" class="btn btn-installer" id="continueBtn" disabled>
                Continue <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        document.getElementById('testConnection').addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            const resultDiv = document.getElementById('connectionResult');
            const continueBtn = document.getElementById('continueBtn');

            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Testing...';
            btn.disabled = true;

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            formData.append('db_host', document.getElementById('db_host').value);
            formData.append('db_port', document.getElementById('db_port').value);
            formData.append('db_name', document.getElementById('db_name').value);
            formData.append('db_username', document.getElementById('db_username').value);
            formData.append('db_password', document.getElementById('db_password').value);

            axios.post('{{ route('install.test.database') }}', formData)
                .then(function(response) {
                    if (response.data.success) {
                        resultDiv.innerHTML =
                            '<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>' +
                            response.data.message + '</div>';
                        continueBtn.disabled = false;
                    } else {
                        resultDiv.innerHTML =
                            '<div class="alert alert-danger"><i class="fas fa-times-circle me-2"></i>' +
                            response.data.message + '</div>';
                        continueBtn.disabled = true;
                    }
                })
                .catch(function(error) {
                    resultDiv.innerHTML =
                        '<div class="alert alert-danger"><i class="fas fa-times-circle me-2"></i>Connection test failed. Please check your credentials.</div>';
                    continueBtn.disabled = true;
                })
                .finally(function() {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                });
        });
    </script>
@endsection
