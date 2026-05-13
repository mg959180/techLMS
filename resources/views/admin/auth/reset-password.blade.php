<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Change Password | {{ config('app.name', 'TechLMS') }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 24px;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #14213d;
            background: #f5f7fb;
        }
        .card {
            width: min(100%, 480px);
            padding: clamp(24px, 5vw, 42px);
            border: 1px solid #d9e2ec;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 24px 70px rgba(16, 42, 67, .12);
        }
        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 28px;
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
        h1 {
            margin: 0;
            font-size: clamp(28px, 7vw, 38px);
            letter-spacing: 0;
        }
        p {
            margin: 10px 0 26px;
            color: #5f6c7b;
            line-height: 1.65;
        }
        .alert {
            margin-bottom: 18px;
            padding: 13px 14px;
            border-radius: 8px;
            color: #842029;
            background: #f8d7da;
            border: 1px solid #f1aeb5;
            font-size: 14px;
            line-height: 1.5;
        }
        .field { margin-bottom: 18px; }
        label {
            display: block;
            margin-bottom: 8px;
            color: #243b53;
            font-size: 14px;
            font-weight: 700;
        }
        input {
            width: 100%;
            min-height: 50px;
            padding: 13px 14px;
            border: 1px solid #d9e2ec;
            border-radius: 8px;
            color: #102a43;
            font-size: 16px;
            outline: none;
        }
        input:focus {
            border-color: #1f7a8c;
            box-shadow: 0 0 0 4px rgba(31, 122, 140, .14);
        }
        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-top: 24px;
            flex-wrap: wrap;
        }
        a {
            color: #1f7a8c;
            font-weight: 700;
            text-decoration: none;
        }
        a:hover { text-decoration: underline; }
        button {
            min-height: 50px;
            padding: 0 22px;
            border: 0;
            border-radius: 8px;
            color: #fff;
            background: #1f7a8c;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
        }
        button:hover { background: #14596a; }
        @media (max-width: 440px) {
            body { padding: 16px; }
            .actions { align-items: stretch; }
            button { width: 100%; }
        }
    </style>
</head>
<body>
    <main class="card">
        <div class="brand">
            <span class="brand-mark">TL</span>
            <span>{{ config('app.name', 'TechLMS') }}</span>
        </div>

        <h1>Create new password</h1>
        <p>Choose a new password for your admin account.</p>

        @if ($errors->any())
            <div class="alert">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.change-password') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="field">
                <label for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required autocomplete="username" placeholder="admin@example.com">
            </div>

            <div class="field">
                <label for="password">New password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Enter a new password">
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your new password">
            </div>

            <div class="actions">
                <a href="{{ route('admin.login') }}">Back to login</a>
                <button type="submit">Update password</button>
            </div>
        </form>
    </main>
</body>
</html>
