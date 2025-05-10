<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Mode</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: "Montserrat", sans-serif;
            background-color: #fff;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .panel {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: none;
            text-align: center;
            margin-bottom: 20px;
        }

        .panel h2 {
            margin-top: 0;
            color: #333;
        }

         .panel svg {
            width:125px;
            fill:red;
        }

        .panel p {
            margin-bottom: 20px;
            color: #666;
            line-height: 2.0;
            font-size: 1.8rem;
        }

        .broken-icon {
            width: 64px;
            margin-bottom: 20px;
            fill: red;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: none;
            border-radius: 0 0 8px 8px;
            box-shadow: none;
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .footer p{
            text-align: center !important;
            font-size:14px;
        }
        .footer a {
            color: #6978fa;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="panel">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
            </svg>
            {{-- <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;width:60px;}</style></defs><title/><g data-name="Layer 2" id="Layer_2"><path d="M22.7,28H9.3a6.25,6.25,0,0,1-5.47-3.15,6.15,6.15,0,0,1,0-6.22L10.56,7.12a6.3,6.3,0,0,1,10.88,0l6.71,11.51h0a6.15,6.15,0,0,1,0,6.22A6.25,6.25,0,0,1,22.7,28ZM16,6a4.24,4.24,0,0,0-3.71,2.12L5.58,19.64a4.15,4.15,0,0,0,0,4.21A4.23,4.23,0,0,0,9.3,26H22.7a4.23,4.23,0,0,0,3.73-2.15,4.15,4.15,0,0,0,0-4.21L19.71,8.12A4.24,4.24,0,0,0,16,6Z"/><path class="cls-1" d="M16,12a.54.54,0,0,0-.44.22.52.52,0,0,0-.1.48L16,14.88l.54-2.18a.52.52,0,0,0-.1-.48A.54.54,0,0,0,16,12Z"/><path d="M18,11a2.56,2.56,0,0,0-4,0,2.5,2.5,0,0,0-.46,2.19L15,19.24a1,1,0,0,0,1.94,0l1.51-6.06A2.5,2.5,0,0,0,18,11ZM16.54,12.7,16,14.88l-.54-2.18a.52.52,0,0,1,.1-.48.55.55,0,0,1,.88,0A.52.52,0,0,1,16.54,12.7Z"/><circle cx="16" cy="22.5" r="1.5"/></g><g id="frame"><rect class="cls-1 blocked-icon" height="32" width="32"/></g></svg> --}}
            <h2>Maintenance Mode</h2>
            <p>We are currenctly undergoing some maintenance. <br> Please check back later</p>
        </div>
    </div>
    <div class="footer">
        <p>Powered By <a href="https://aevosmm.com" target="_blank"><img src="https://aevosmm.com/public/uploads/GCObhNnDMylogo.png" alt="Aevosmm Logo" height="30" width="auto" class=""></a></p>
    </div>
</body>
</html>
