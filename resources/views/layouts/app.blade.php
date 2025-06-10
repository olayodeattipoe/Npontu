<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>NPONTU</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-900">
            @auth
                <div class="dashboard-container">
                    <!-- Sidebar -->
                    <div class="sidebar" id="sidebar">
                        <div class="sidebar-header">
                            <a href="{{ route('home') }}" class="logo">
                                <i class="fas fa-chart-line"></i>
                                <span>NPONTU</span>
                            </a>
                            <button class="close-sidebar" onclick="toggleSidebar()">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        </div>
                        <nav class="sidebar-nav">
                            <ul>
                                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                    <a href="{{ route('home') }}">
                                        <i class="fas fa-home"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('activities.*') ? 'active' : '' }}">
                                    <a href="{{ route('activities.index') }}">
                                        <i class="fas fa-tasks"></i>
                                        <span>Activities</span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('team.index') ? 'active' : '' }}">
                                    <a href="{{ route('team.index') }}">
                                        <i class="fas fa-users"></i>
                                        <span>Team</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <!-- Main Content -->
                    <div class="main-content">
                        <!-- Top Bar -->
                        <div class="top-bar">
                            <button class="hamburger" onclick="toggleSidebar()">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="search-bar">
                                <input type="text" placeholder="Search activities...">
                                <i class="fas fa-search"></i>
                            </div>
                            <div class="user-menu">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <div class="dropdown">
                                    <button class="dropdown-toggle">
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Page Content -->
                        <main>
                            @yield('content')
                        </main>
                    </div>
                </div>
            @else
                <main>
                    @yield('content')
                </main>
            @endauth
        </div>

        <style>
            body {
                background: #121212;
                color: #ffffff;
                margin: 0;
                font-family: 'Figtree', sans-serif;
            }

            .dashboard-container {
                display: flex;
                min-height: 100vh;
            }

            /* Sidebar */
            .sidebar {
                width: 250px;
                background: #181818;
                padding: 24px;
                transition: all 0.3s ease;
            }

            .sidebar.collapsed {
                width: 70px;
            }

            .sidebar-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 32px;
            }

            .sidebar-header h3 {
                color: #1db954;
                margin: 0;
                font-size: 20px;
            }

            .close-sidebar {
                background: none;
                border: none;
                color: #b3b3b3;
                cursor: pointer;
                padding: 8px;
                border-radius: 4px;
                transition: all 0.2s;
            }

            .close-sidebar:hover {
                color: #ffffff;
                background: #282828;
            }

            .sidebar-nav ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .sidebar-nav li {
                margin-bottom: 8px;
            }

            .sidebar-nav a {
                display: flex;
                align-items: center;
                padding: 12px;
                color: #b3b3b3;
                text-decoration: none;
                border-radius: 4px;
                transition: all 0.2s;
            }

            .sidebar-nav a:hover {
                background: #282828;
                color: #ffffff;
            }

            .sidebar-nav a.active {
                background: #282828;
                color: #1db954;
            }

            .sidebar-nav i {
                width: 24px;
                margin-right: 12px;
            }

            .sidebar.collapsed .sidebar-nav span {
                display: none;
            }

            /* Main Content */
            .main-content {
                flex: 1;
                padding: 24px;
                transition: all 0.3s ease;
            }

            /* Top Bar */
            .top-bar {
                display: flex;
                align-items: center;
                gap: 24px;
                margin-bottom: 24px;
                padding: 16px;
                background: #181818;
                border-radius: 8px;
            }

            .hamburger {
                background: none;
                border: none;
                color: #b3b3b3;
                cursor: pointer;
                padding: 8px;
                border-radius: 4px;
                transition: all 0.2s;
            }

            .hamburger:hover {
                color: #ffffff;
                background: #282828;
            }

            .search-bar {
                flex: 1;
                position: relative;
            }

            .search-bar input {
                width: 100%;
                padding: 12px 40px 12px 16px;
                background: #282828;
                border: none;
                border-radius: 20px;
                color: #ffffff;
                font-size: 14px;
            }

            .search-bar i {
                position: absolute;
                right: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: #b3b3b3;
            }

            .user-menu {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .user-name {
                color: #ffffff;
                font-size: 14px;
            }

            .dropdown {
                position: relative;
            }

            .dropdown-toggle {
                background: none;
                border: none;
                color: #b3b3b3;
                cursor: pointer;
                padding: 8px;
                border-radius: 4px;
                transition: all 0.2s;
            }

            .dropdown-toggle:hover {
                color: #ffffff;
                background: #282828;
            }

            .dropdown-menu {
                position: absolute;
                top: 100%;
                right: 0;
                background: #181818;
                border-radius: 4px;
                padding: 8px 0;
                min-width: 160px;
                display: none;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .dropdown:hover .dropdown-menu {
                display: block;
            }

            .dropdown-menu a,
            .dropdown-menu button {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 8px 16px;
                color: #b3b3b3;
                text-decoration: none;
                border: none;
                background: none;
                width: 100%;
                text-align: left;
                cursor: pointer;
                font-size: 14px;
                transition: all 0.2s;
            }

            .dropdown-menu a:hover,
            .dropdown-menu button:hover {
                background: #282828;
                color: #ffffff;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .sidebar {
                    position: fixed;
                    left: -250px;
                    top: 0;
                    bottom: 0;
                    z-index: 1000;
                }

                .sidebar.active {
                    left: 0;
                }

                .main-content {
                    margin-left: 0;
                }

                .top-bar {
                    flex-wrap: wrap;
                }

                .search-bar {
                    order: 3;
                    width: 100%;
                    margin-top: 16px;
                }
            }
        </style>

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('collapsed');
            }
        </script>
    </body>
</html>
