<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify your email</title>
    <style>
        body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; margin:0; padding:40px; background:#0f172a; color:#e5e7eb; }
        .card { max-width: 520px; margin: 0 auto; background:#0b1220; border:1px solid #1e293b; border-radius:14px; padding:24px; }
        h1 { margin:0 0 10px; font-size:22px; }
        p { color:#94a3b8; }
        form { margin-top:18px; }
        button { appearance:none; border:0; border-radius:10px; padding:10px 14px; font-weight:600; cursor:pointer; background:linear-gradient(135deg,#2563eb,#3b82f6); color:white; }
        .flash { margin:10px 0; padding:10px; border-radius:8px; background:#052e1b; color:#bbf7d0; border:1px solid #14532d; }
        .error { background:#3f1d1d; color:#fecaca; border-color:#7f1d1d; }
    </style>
    </head>
<body>
    <div class="card">
        <h1>Verify your email</h1>
        <p>A verification link was sent to your email. If you didn’t receive it, you can request another one.</p>
        @if (session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="flash error">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">Resend verification email</button>
        </form>
    </div>
</body>
</html>

