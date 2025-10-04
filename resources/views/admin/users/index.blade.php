<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Users</title>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>
    body {
        margin:0;
        font-family:'Poppins',sans-serif;
        background:#f9f9f9 url('{{ asset('images/perfumes-bg.jpg') }}') no-repeat center center;
        background-size:cover;
        padding:40px;
    }
    .card-container {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(5px);
        padding:25px 30px;
        border-radius:20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    h1 { color:#ff6f61; margin-bottom:20px; }
    table { width:100%; border-collapse:collapse; }
    th,td { padding:12px; border-bottom:1px solid #ddd; text-align:left; }
    th { background:#ff6f61; color:white; }
    form button { background:none; border:none; color:#d32f2f; cursor:pointer; }
</style>
</head>
<body>
<div class="card-container">
    <h1>All Users</h1>

    @if(session('success'))
        <div style="background:#e6f7e6;color:#2d7a2d;padding:10px;border-radius:8px;margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
