<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AEVO SMM - Application Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .installer-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="installer-container">
        <h1 class="text-center mb-4">AEVO SMM - Application Settings</h1>
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('install.setup') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="app_name" class="form-label">Application Name</label>
                <input type="text" class="form-control" id="app_name" name="app_name" value="AEVO SMM" required>
            </div>

            <div class="mb-3">
                <label for="app_url" class="form-label">Application URL</label>
                <input type="url" class="form-control" id="app_url" name="app_url" required>
            </div>

            <div class="mb-3">
                <label for="admin_email" class="form-label">Admin Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" required>
                <div class="form-text">This will be used as the administrator account.</div>
            </div>

            <div class="mb-3">
                <label for="admin_password" class="form-label">Admin Password</label>
                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
            </div>

            <div class="mb-3">
                <label for="admin_password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="admin_password_confirmation" name="admin_password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Complete Installation</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
