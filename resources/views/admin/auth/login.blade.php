<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | {{ config('app.name', 'TechLMS') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #14213d;
            background: #f5f7fb;
        }
        .auth-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, 520px);
        }
        .auth-visual {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(28px, 5vw, 72px);
            color: #fff;
            background:
                linear-gradient(135deg, rgba(13, 27, 42, .92), rgba(31, 122, 140, .78)),
                url("https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1600&q=80") center/cover;
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 800;
        }
        .brand-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: #fca311;
            color: #102a43;
            font-weight: 900;
        }
        .visual-copy { max-width: 640px; }
        .visual-copy h1 {
            margin: 0 0 18px;
            font-size: clamp(36px, 5vw, 68px);
            line-height: 1;
            letter-spacing: 0;
        }
        .visual-copy p {
            max-width: 560px;
            margin: 0;
            color: rgba(255, 255, 255, .82);
            font-size: clamp(16px, 2vw, 20px);
            line-height: 1.7;
        }
        .auth-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(22px, 5vw, 56px);
            background: #ffffff;
        }
        .form-wrap { width: min(100%, 420px); }
        .mobile-brand {
            display: none;
            margin-bottom: 28px;
            color: #14213d;
        }
        h2 {
            margin: 0;
            font-size: clamp(28px, 4vw, 38px);
            letter-spacing: 0;
        }
        .subtext {
            margin: 10px 0 28px;
            color: #5f6c7b;
            line-height: 1.6;
        }
        .alert {
            margin-bottom: 18px;
            padding: 13px 14px;
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.5;
        }
        .alert-success { color: #0f5132; background: #dff6e8; border: 1px solid #bde8ce; }
        .alert-error { color: #842029; background: #f8d7da; border: 1px solid #f1aeb5; }
        .field { margin-bottom: 18px; }
        label {
            display: block;
            margin-bottom: 8px;
            color: #243b53;
            font-size: 14px;
            font-weight: 700;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            min-height: 50px;
            padding: 13px 14px;
            border: 1px solid #d9e2ec;
            border-radius: 8px;
            color: #102a43;
            font-size: 16px;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        input:focus {
            border-color: #1f7a8c;
            box-shadow: 0 0 0 4px rgba(31, 122, 140, .14);
        }
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin: 4px 0 24px;
            flex-wrap: wrap;
        }
        .check-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin: 0;
            color: #52616f;
            font-weight: 600;
            cursor: pointer;
        }
        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #1f7a8c;
        }
        a {
            color: #1f7a8c;
            font-weight: 700;
            text-decoration: none;
        }
        a:hover { text-decoration: underline; }
        .submit-btn {
            width: 100%;
            min-height: 52px;
            border: 0;
            border-radius: 8px;
            color: #fff;
            background: #1f7a8c;
            font-size: 16px;
            font-weight: 800;
            cursor: pointer;
            transition: transform .2s, background .2s;
        }
        .submit-btn:hover {
            background: #14596a;
            transform: translateY(-1px);
        }
        .footer-note {
            margin-top: 26px;
            color: #7b8794;
            font-size: 14px;
            line-height: 1.6;
            text-align: center;
        }
        @media (max-width: 900px) {
            .auth-page { grid-template-columns: 1fr; }
            .auth-visual { display: none; }
            .auth-panel {
                min-height: 100vh;
                align-items: flex-start;
                padding-top: clamp(32px, 10vw, 72px);
            }
            .mobile-brand { display: inline-flex; }
        }
        @media (max-width: 440px) {
            .auth-panel { padding-inline: 18px; }
            .form-row { align-items: flex-start; }
        }
    </style>
</head>
<body>
    <main class="auth-page">
        <section class="auth-visual" aria-label="TechLMS admin portal">
            <div class="brand">
                <span class="brand-mark">TL</span>
                <span>{{ config('app.name', 'TechLMS') }}</span>
            </div>

            <div class="visual-copy">
                <h1>Manage learning with clarity.</h1>
                <p>Access courses, students, reports, and platform settings from one focused admin workspace.</p>
            </div>
        </section>

        <section class="auth-panel">
            <div class="form-wrap">
                <div class="brand mobile-brand">
                    <span class="brand-mark">TL</span>
                    <span>{{ config('app.name', 'TechLMS') }}</span>
                </div>

                <h2>Welcome back</h2>
                <p class="subtext">Sign in to continue to your admin dashboard.</p>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.auth') }}">
                    @csrf

                    <div class="field">
                        <label for="email">Email address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@example.com">
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password">
                    </div>

                    <div class="form-row">
                        <label class="check-label" for="remember">
                            <input id="remember" type="checkbox" name="remember" value="1" @checked(old('remember'))>
                            <span>Remember me</span>
                        </label>

                        <a href="{{ route('admin.forget-password') }}">Forgot password?</a>
                    </div>

                    <button class="submit-btn" type="submit">Sign in</button>
                </form>

                <p class="footer-note">Use your registered admin account to access this area.</p>
            </div>
        </section>
    </main>
</body>
</html>
