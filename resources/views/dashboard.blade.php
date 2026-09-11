<!DOCTYPE html>
<html lang="id">
<head><meta charset="utf-8"><title>Dashboard</title></head>
<body style="font-family: sans-serif; padding: 40px;">
    <h1>Selamat datang, {{ auth()->user()->name }}!</h1>
    <p>Role kamu : <strong>{{ auth()->user()->role }}</strong></p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>