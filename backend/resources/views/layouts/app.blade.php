<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'EgyptNet ISP Management')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Tahoma', Arial, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            color: white;
            padding: 20px;
        }
        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: #34495e;
        }
        .sidebar a.active {
            background: #3498db;
        }
        .main-content {
            padding: 20px;
        }
        .navbar-brand {
            font-weight: bold;
            color: #3498db !important;
        }
        .card-stats {
            border-radius: 15px;
            transition: transform 0.3s;
        }
        .card-stats:hover {
            transform: scale(1.02);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-md-block sidebar">
                <div class="position-sticky">
                    <h4 class="text-center py-3">📡 EgyptNet</h4>
                    <hr class="border-light">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dhcp.*') ? 'active' : ' ' }}" 
                                   href="{{ route('dhcp.index') }}">
                                    <i class="fas fa-network-wired"></i> DHCP
                                </a>
                            </li>
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dhcp.*') ? 'active' : ' ' }}" 
                                   href="{{ route('dhcp.index') }}">
                                    <i class="fas fa-network-wired"></i> DHCP
                                </a>
                            </li>
                            <a class="nav-link {{ request()->routeIs('queues.*') ? 'active' : '' }}" 
                               href="{{ route('queues.index') }}">
                                <i class="fas fa-chart-line"></i> Queues
                            </a>
                        </li>
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dhcp.*') ? 'active' : ' ' }}" 
                                   href="{{ route('dhcp.index') }}">
                                    <i class="fas fa-network-wired"></i> DHCP
                                </a>
                            </li>
                            <a class="nav-link" href="#">
                                <i class="fas fa-firewall"></i> Firewall
                            </a>
                        </li>
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dhcp.*') ? 'active' : ' ' }}" 
                                   href="{{ route('dhcp.index') }}">
                                    <i class="fas fa-network-wired"></i> DHCP
                                </a>
                            </li>
                            <a class="nav-link" href="#">
                                <i class="fas fa-network-wired"></i> DHCP
                            </a>
                        </li>
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dhcp.*') ? 'active' : ' ' }}" 
                                   href="{{ route('dhcp.index') }}">
                                    <i class="fas fa-network-wired"></i> DHCP
                                </a>
                            </li>
                            <a class="nav-link" href="#">
                                <i class="fas fa-users"></i> العملاء
                            </a>
                        </li>
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dhcp.*') ? 'active' : ' ' }}" 
                                   href="{{ route('dhcp.index') }}">
                                    <i class="fas fa-network-wired"></i> DHCP
                                </a>
                            </li>
                            <a class="nav-link" href="#">
                                <i class="fas fa-money-bill"></i> الفواتير
                            </a>
                        </li>
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dhcp.*') ? 'active' : ' ' }}" 
                                   href="{{ route('dhcp.index') }}">
                                    <i class="fas fa-network-wired"></i> DHCP
                                </a>
                            </li>
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog"></i> الإعدادات
                            </a>
                        </li>
                    </ul>
                    <hr class="border-light">
                    <div class="text-center">
                        <small class="text-muted">v1.0.0</small>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-md-4 main-content">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light rounded mb-4">
                    <div class="container-fluid">
                        <span class="navbar-brand">@yield('title', 'لوحة التحكم')</span>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dhcp.*') ? 'active' : ' ' }}" 
                                   href="{{ route('dhcp.index') }}">
                                    <i class="fas fa-network-wired"></i> DHCP
                                </a>
                            </li>
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-bell"></i>
                                        <span class="badge bg-danger">3</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dhcp.*') ? 'active' : ' ' }}" 
                                   href="{{ route('dhcp.index') }}">
                                    <i class="fas fa-network-wired"></i> DHCP
                                </a>
                            </li>
                                    <span class="nav-link">
                                        <i class="fas fa-user-circle"></i> Admin
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
