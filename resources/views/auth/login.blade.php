<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/style.css')
</head>
<body>
    <main class="page-shell">
        <section class="auth-card">
        <h1>Login</h1>

        @if (session('success'))
            <div class="success" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>
            <label class="remember-row" for="remember">
                <input id="remember" name="remember" type="checkbox" value="1">
                Remember me
            </label>

            <button type="submit">Login</button>
        </form>

        <a class="text-link" href="{{ route('register') }}">Create an account</a>
        </section>
    </main>
</body>
</html>