<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard | {{ config('app.name', 'TechLMS') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #14213d;
            background: #f5f7fb;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 18px clamp(18px, 5vw, 56px);
            background: #fff;
            border-bottom: 1px solid #d9e2ec;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 800;
        }
        .brand-mark {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: #fca311;
            color: #102a43;
            font-weight: 900;
        }
        a {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 16px;
            border-radius: 8px;
            color: #fff;
            background: #1f7a8c;
            font-weight: 800;
            text-decoration: none;
        }
        main {
            width: min(100%, 1040px);
            margin: 0 auto;
            padding: clamp(28px, 6vw, 64px) clamp(18px, 5vw, 32px);
        }
        h1 {
            margin: 0 0 10px;
            font-size: clamp(30px, 5vw, 48px);
            letter-spacing: 0;
        }
        p {
            max-width: 680px;
            margin: 0;
            color: #5f6c7b;
            line-height: 1.7;
        }
        @media (max-width: 520px) {
            header { align-items: flex-start; flex-direction: column; }
            a { width: 100%; }
        }
    </style>
</head>
<body>
    <header>
        <div class="brand">
            <span class="brand-mark">TL</span>
            <span>{{ config('app.name', 'TechLMS') }}</span>
        </div>
        <a href="{{ route('admin.logout') }}">Log out</a>
    </header>

    <main>
        <h1>Admin dashboard</h1>
        <p>Welcome{{ session('admin_name') ? ', '.session('admin_name') : '' }}. Your admin login flow is ready.</p>
    </main>
</body>
</html>
