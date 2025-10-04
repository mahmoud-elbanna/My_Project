<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f9f9f9 url('{{ asset('images/perfumes-bg.jpg') }}') no-repeat center center;
            background-size: cover;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.75);
            padding: 50px 40px;
            border-radius: 25px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.2);
            width: 420px;
            max-width: 90%;
            text-align: center;
            backdrop-filter: blur(7px);
            animation: fadeIn 1s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px);}
            to { opacity: 1; transform: translateY(0);}
        }

        .form-container h1 {
            margin-bottom: 25px;
            color: #333;
            font-size: 30px;
            font-weight: 600;
        }

        .form-container input {
            width: 100%;
            padding: 14px 18px;
            margin: 12px 0;
            border-radius: 12px;
            border: 1px solid #ccc;
            outline: none;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-container input:focus {
            border-color: #ff6f61;
            box-shadow: 0 0 10px rgba(255,111,97,0.4);
        }

        .form-container input::placeholder {
            color: #aaa;
            font-weight: 500;
        }

        .form-container button {
            width: 100%;
            padding: 14px;
            margin-top: 20px;
            border: none;
            background: #ff6f61;
            color: white;
            font-size: 17px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-container button:hover {
            background: #ff856f;
        }

        .form-container p {
            margin-top: 18px;
            font-size: 15px;
        }

        .error-message {
            background: #fdecea;
            color: #d32f2f;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 12px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Admin Login</h1>

        @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p>Don't have an account? <a href="{{ route('admin.register') }}" style="color:#ff6f61;">Register</a></p>
    </div>

</body>
</html>
