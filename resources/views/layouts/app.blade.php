<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>
    <style>
        .navbar-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        
        .navbar-brand-modern {
            font-size: 1.5rem;
            font-weight: bold;
            color: white !important;
            text-decoration: none;
        }
        
        .navbar-brand-modern:hover {
            color: #f8f9fa !important;
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
        
        .nav-link-modern {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            padding: 10px 20px !important;
            margin: 0 5px;
            border-radius: 25px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .nav-link-modern:hover {
            background: rgba(255,255,255,0.2);
            color: white !important;
            transform: translateY(-2px);
        }
        
        .nav-link-modern.active {
            background: rgba(255,255,255,0.3);
            color: white !important;
        }
        
        .admin-badge {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 20px;
            padding: 8px 16px;
            color: white;
        }
    </style>

    <nav class="navbar navbar-expand-lg navbar-modern">
        <div class="container">
            <a class="navbar-brand-modern" href="{{ route('dashboard') }}">
                <i class="fas fa-home me-2"></i>Quản Lý Nhà Trọ
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="color: white;">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('rooms.*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">
                            <i class="fas fa-door-open me-1"></i>Phòng Trọ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('tenants.*') ? 'active' : '' }}" href="{{ route('tenants.index') }}">
                            <i class="fas fa-users me-1"></i>Khách Thuê
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('contracts.*') ? 'active' : '' }}" href="{{ route('contracts.index') }}">
                            <i class="fas fa-file-contract me-1"></i>Hợp Đồng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-modern {{ request()->routeIs('payments.*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                            <i class="fas fa-money-bill me-1"></i>Thanh Toán
                        </a>
                    </li>
                </ul>
                
                <div class="admin-badge">
                    <i class="fas fa-user-shield me-2"></i>Admin
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>