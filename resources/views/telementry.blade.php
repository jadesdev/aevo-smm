<!DOCTYPE html>
<html>

<head>
    <title>Invalid License - Access Denied</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background particles */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
        }

        .particle:nth-child(2) {
            left: 20%;
            animation-delay: 0.5s;
        }

        .particle:nth-child(3) {
            left: 30%;
            animation-delay: 1s;
        }

        .particle:nth-child(4) {
            left: 40%;
            animation-delay: 1.5s;
        }

        .particle:nth-child(5) {
            left: 50%;
            animation-delay: 2s;
        }

        .particle:nth-child(6) {
            left: 60%;
            animation-delay: 2.5s;
        }

        .particle:nth-child(7) {
            left: 70%;
            animation-delay: 3s;
        }

        .particle:nth-child(8) {
            left: 80%;
            animation-delay: 3.5s;
        }

        .particle:nth-child(9) {
            left: 90%;
            animation-delay: 4s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        .container {
            position: relative;
            z-index: 10;
            max-width: 500px;
            width: 90%;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .panel {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .icon-container {
            position: relative;
            display: inline-block;
            margin-bottom: 30px;
        }

        .shield-icon {
            width: 80px;
            height: 80px;
            fill: #e74c3c;
            filter: drop-shadow(0 10px 20px rgba(231, 76, 60, 0.3));
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .status-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #e74c3c;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            animation: blink 1.5s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .panel h1 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .panel h2 {
            color: #e74c3c;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .panel p {
            color: #5a6c7d;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            font-weight: 400;
        }

        .domain-info {
            background: rgba(231, 76, 60, 0.1);
            border: 1px solid rgba(231, 76, 60, 0.2);
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            text-align: left;
        }

        .domain-info h3 {
            color: #e74c3c;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .domain-info p {
            color: #2c3e50;
            font-size: 14px;
            margin: 8px 0;
            font-family: 'Monaco', 'Consolas', monospace;
            background: rgba(255, 255, 255, 0.7);
            padding: 8px 12px;
            border-radius: 6px;
            border-left: 3px solid #e74c3c;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            min-width: 140px;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #2c3e50;
            border: 1px solid rgba(44, 62, 80, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 10;
        }

        .footer p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 400;
        }

        .footer a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .footer a:hover {
            color: #667eea;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 600px) {
            .panel {
                padding: 40px 30px;
                margin: 20px;
            }

            .panel h1 {
                font-size: 24px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                min-width: auto;
            }
        }

        /* Glitch effect for dramatic emphasis */
        .glitch {
            animation: glitch 0.3s ease-in-out infinite alternate;
        }

        @keyframes glitch {
            0% {
                transform: translate(0);
            }

            20% {
                transform: translate(-2px, 2px);
            }

            40% {
                transform: translate(-2px, -2px);
            }

            60% {
                transform: translate(2px, 2px);
            }

            80% {
                transform: translate(2px, -2px);
            }

            100% {
                transform: translate(0);
            }
        }
    </style>
</head>

<body>
    <div class="particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>

    <div class="container">
        <div class="panel">
            <div class="icon-container">
                <svg class="shield-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11H15.5C16.4,11 17,11.4 17,12V16C17,16.6 16.6,17 16,17H8C7.4,17 7,16.6 7,16V12C7,11.4 7.4,11 8,11H8.5V10C8.5,8.6 9.6,7 12,7M12,8.2C10.2,8.2 9.5,9.2 9.5,10V11H14.5V10C14.5,9.2 13.8,8.2 12,8.2Z" />
                </svg>
                <div class="status-badge">Invalid</div>
            </div>

            <h1>Access Denied</h1>
            <h2 class="glitch">Invalid License</h2>

            <p>This domain is not authorized to run AEVOSMM. The software license is either missing, expired,
                or not registered for this domain.</p>

            <div class="domain-info">
                <h3>Current Domain Issue:</h3>
                <p id="current-domain">Domain: Loading...</p>
                <p>Status: <span style="color: #e74c3c; font-weight: 600;">Unauthorized</span></p>
                <p>License: <span style="color: #e74c3c; font-weight: 600;">Not Valid</span></p>
            </div>

            <p style="font-size: 14px; color: #7f8c8d;">To continue using AEVOSMM, please ensure you have a valid
                license and the domain is properly registered.</p>

            <div class="action-buttons">
                <a href="https://app.aevosmm.com" class="btn btn-primary" target="_blank">Get License</a>
                <a href="https://wa.me/2349039941461" class="btn btn-secondary" target="_blank">Contact
                    Support</a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Powered By <a href="https://app.aevosmm.com" target="_blank">AEVOSMM</a> • Licensed Software</p>
    </div>

    <script>
        // Display current domain
        document.getElementById('current-domain').textContent = 'Domain: ' + window.location.hostname;

        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255, 255, 255, 0.3)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.pointerEvents = 'none';

                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Random glitch effect
            setInterval(() => {
                const glitchElement = document.querySelector('.glitch');
                glitchElement.style.animation = 'none';
                setTimeout(() => {
                    glitchElement.style.animation = 'glitch 0.3s ease-in-out infinite alternate';
                }, 50);
            }, 5000);
        });

        // CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>

</html>
