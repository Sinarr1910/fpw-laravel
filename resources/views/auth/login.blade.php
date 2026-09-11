<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login Fpw Laravel</title>
</head>
<body style="font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f3f4f6;">
    <div style="background: white; padding: 32px; border-radius: 8px; width: 320px;">
        <h1 style="text-align: center; margin-bottom: 24px;">Fpw Laravel</h1>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 16px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 12px;">
                <label>Email</label><br>
                <input type="email" name="email" value="{{ old('email') }}" style="width: 100%; padding: 8px;" required autofocus>
            </div>
            <div style="margin-bottom: 16px;">
                <label>Password</label><br>
                <input type="password" name="password" style="width: 100%; padding: 8px;" required>
            </div>
            <button type="submit" style="width: 100%; padding: 10px; background: #4f46e5; color: white; border: none; border-radius: 6px;">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>