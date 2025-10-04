<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome back</title>
    <style>
        :root { --bg:#0f172a; --card:#0b1220; --muted:#94a3b8; --border:#1e293b; --accent:#2563eb; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji"; background:linear-gradient(180deg,#0b1020,#0f172a 40%,#0b1220); color:#e5e7eb; }
        .wrap { min-height:100dvh; display:grid; place-items:center; padding:32px; }
        .card { width:100%; max-width: 420px; background:var(--card); border:1px solid var(--border); border-radius:16px; padding:28px; box-shadow:0 10px 30px rgba(0,0,0,.35); }
        h1 { margin:0 0 6px; font-size:24px; letter-spacing:.2px; }
        p.lead { margin:0 0 22px; color:var(--muted); font-size:14px; }
        label { display:block; font-size:13px; margin:14px 0 6px; color:#cbd5e1; }
        input { width:100%; height:42px; padding:10px 12px; background:#0a0f1c; border:1px solid var(--border); border-radius:10px; color:#e5e7eb; font-size:14px; outline:none; transition:border-color .15s ease, box-shadow .15s ease; }
        input::placeholder { color:#64748b; }
        input:focus { border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.15); }
        .row { display:flex; justify-content:space-between; align-items:center; margin-top:10px; }
        
        /* ✅ تعديل Remember me */
        .remember { display:flex; align-items:center; gap:6px; font-size:12px; color:#cbd5e1; }
        .remember input[type="checkbox"] {
            width:14px;
            height:14px;
            accent-color: var(--accent);
            margin:0;
        }

        .pwd { position:relative; }
        .toggle { position:absolute; top:50%; right:10px; transform:translateY(-50%); background:transparent; color:#94a3b8; border:0; padding:6px; cursor:pointer; font-size:12px; }
        .actions { margin-top:18px; display:flex; gap:12px; align-items:center; }
        .btn { appearance:none; border:0; border-radius:10px; padding:10px 14px; font-weight:600; cursor:pointer; }
        .btn-primary { background:linear-gradient(135deg,#2563eb,#3b82f6); color:white; width:100%; height:44px; }
        .btn-primary:hover { filter:brightness(1.05); }
        .muted { color:var(--muted); font-size:12px; margin-top:14px; text-align:center; }
        a { color:#60a5fa; text-decoration:none; }
        a:hover { text-decoration:underline; }

        /* ✅ رسائل التنبيه */
        .alert { margin:10px 0; padding:10px; border-radius:8px; font-size:13px; opacity:1; transition:opacity .6s ease; }
        .alert.error { background:#3f1d1d; color:#fecaca; border:1px solid #7f1d1d; }
        .alert.success { background:#052e1b; color:#bbf7d0; border:1px solid #14532d; }
        .alert.hide { opacity:0; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="card">
        <h1>Welcome back</h1>
        <p class="lead">Sign in to continue</p>

        @if (session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert error">
                <ul style="margin:0 0 0 16px; padding:0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="you@example.com" autocomplete="username" >

            <label for="password">Password</label>
            <div class="pwd">
                <input id="password" name="password" type="password" placeholder="••••••••" autocomplete="current-password" >
                <button class="toggle" type="button" data-target="password">Show</button>
            </div>

            <div class="row">
                <label class="remember">
                    <input type="checkbox" name="remember" value="1"> Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit">Sign in</button>
            </div>
        </form>
        <div class="muted">New here? <a href="{{ url('/register') }}">Create an account</a></div>
    </div>
</div>

<script>
    // ✅ زرار show/hide password
    (function() {
        var btn = document.querySelector('.toggle');
        if (!btn) return;
        btn.addEventListener('click', function(){
            var input = document.getElementById(btn.getAttribute('data-target'));
            if (!input) return;
            var isPwd = input.type === 'password';
            input.type = isPwd ? 'text' : 'password';
            btn.textContent = isPwd ? 'Hide' : 'Show';
        });
    })();

    // ✅ اخفاء الرسائل بعد 3 ثواني
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.classList.add('hide');
            setTimeout(() => el.remove(), 600); // يمسح العنصر بعد الانيميشن
        });
    }, 3000);
</script>
</body>
</html>
