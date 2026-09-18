<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/style.css')
</head>
<body>
    <main class="page-shell">
        <section class="hero">
            <p>Member portal</p>
            <h1>Welcome to the D'Fitness Gym</h1>
            <p>Manage your account and keep your training moving forward.</p>

            @if (session('success'))
                <div class="success" role="status">{{ session('success') }}</div>
            @endif

            <div class="actions">
                <a class="button" href="{{ route('login') }}">Login</a>
                <a class="button" href="{{ route('register') }}">Register</a>
            </div>
        </section>
    </main>
</body>
</html>