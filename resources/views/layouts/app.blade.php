<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>

    {{-- Dùng Vite để load CSS/JS đúng cách --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Không cần load thêm file app.css từ domain khác nữa --}}
    {{-- Nếu bạn muốn dùng bản production từ Railway, cần chắc chắn file tồn tại và đúng đường dẫn --}}
</head>
<body>
    <nav>
        <div class="container">
            <a href="{{ route('dashboard') }}" class="logo">Laravel App</a>
            <div class="nav-links">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit">Đăng Xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Đăng Nhập</a>
                    <a href="{{ route('register') }}">Đăng Ký</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>© 2025 Laravel App</p>
    </footer>
</body>
</html>
