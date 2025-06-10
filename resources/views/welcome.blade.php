<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>NPONTU</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Montserrat', sans-serif;
                background: linear-gradient(to bottom, #1a1a1a, #000000);
                color: #ffffff;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .navbar {
                padding: 24px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(10px);
                position: fixed;
                width: 100%;
                top: 0;
                z-index: 1000;
            }

            .logo {
                font-size: 28px;
                font-weight: 700;
                color: #1db954;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .logo i {
                font-size: 32px;
            }

            .auth-buttons {
                display: flex;
                gap: 16px;
            }

            .btn {
                padding: 12px 24px;
                border-radius: 20px;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.2s;
            }

            .btn-login {
                background: transparent;
                color: #ffffff;
                border: 1px solid #ffffff;
            }

            .btn-login:hover {
                background: rgba(255, 255, 255, 0.1);
            }

            .btn-register {
                background: #1db954;
                color: #000000;
            }

            .btn-register:hover {
                background: #1ed760;
                transform: scale(1.02);
            }

            .hero {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 120px 24px 24px;
            }

            .hero-content {
                max-width: 800px;
            }

            .hero h1 {
                font-size: 64px;
                font-weight: 700;
                margin-bottom: 24px;
                background: linear-gradient(to right, #1db954, #1ed760);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .hero p {
                font-size: 20px;
                color: #b3b3b3;
                margin-bottom: 32px;
                line-height: 1.6;
            }

            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 24px;
                margin-top: 48px;
            }

            .feature-card {
                background: rgba(255, 255, 255, 0.05);
                padding: 24px;
                border-radius: 12px;
                transition: all 0.2s;
            }

            .feature-card:hover {
                transform: translateY(-4px);
                background: rgba(255, 255, 255, 0.1);
            }

            .feature-icon {
                font-size: 32px;
                color: #1db954;
                margin-bottom: 16px;
            }

            .feature-card h3 {
                font-size: 20px;
                margin-bottom: 12px;
            }

            .feature-card p {
                color: #b3b3b3;
                font-size: 14px;
                line-height: 1.6;
            }

            .footer {
                text-align: center;
                padding: 24px;
                color: #b3b3b3;
                font-size: 14px;
            }

            /* Date input styling */
            input[type="date"] {
                background: #282828;
                color: #ffffff;
                border: 1px solid #404040;
                padding: 8px 12px;
                border-radius: 4px;
                font-family: 'Montserrat', sans-serif;
            }

            input[type="date"]::-webkit-calendar-picker-indicator {
                filter: invert(1);
                cursor: pointer;
            }

            input[type="date"]::-webkit-datetime-edit {
                color: #ffffff;
            }

            input[type="date"]::-webkit-datetime-edit-fields-wrapper {
                color: #ffffff;
            }

            input[type="date"]::-webkit-datetime-edit-text {
                color: #ffffff;
            }

            input[type="date"]::-webkit-datetime-edit-month-field {
                color: #ffffff;
            }

            input[type="date"]::-webkit-datetime-edit-day-field {
                color: #ffffff;
            }

            input[type="date"]::-webkit-datetime-edit-year-field {
                color: #ffffff;
            }

            @media (max-width: 768px) {
                .hero h1 {
                    font-size: 48px;
                }

                .hero p {
                    font-size: 18px;
                }

                .features {
                    grid-template-columns: 1fr;
                }

                .auth-buttons {
                    gap: 8px;
                }

                .btn {
                    padding: 8px 16px;
                    font-size: 14px;
                }
            }
        </style>
    </head>
    <body>
        <nav class="navbar">
            <a href="/" class="logo">
                <i class="fas fa-chart-line"></i>
                NPONTU
            </a>
            <div class="auth-buttons">
            @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-login">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-register">Register</a>
                        @endif
                    @endauth
            @endif
                </div>
        </nav>

        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to NPONTU</h1>
                <p>Your ultimate activity tracking and management platform. Stay organized, track progress, and achieve your goals with our intuitive interface.</p>
                
                <div class="features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h3>Activity Tracking</h3>
                        <p>Easily manage and track your daily activities with our intuitive interface.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                </div>
                        <h3>Progress Reports</h3>
                        <p>Get detailed insights and reports on your activity progress and performance.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Team Collaboration</h3>
                        <p>Work seamlessly with your team members and share progress updates.</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <p>&copy; {{ date('Y') }} NPONTU. All rights reserved.</p>
        </footer>
    </body>
</html>
