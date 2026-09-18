<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/style.css')
</head>
<body>
    <main class="page-shell">
        <section class="auth-card">
        <h1>Create an account</h1>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <label for="name">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required>

            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required>

            <label for="membership_plan">Membership type</label>
            <select id="membership_plan" name="membership_plan" required>
                <option value="">Choose a membership</option>
                @foreach (['Monthly', 'Weekly', 'Walk-in'] as $plan)
                    <option value="{{ $plan }}" @selected(old('membership_plan') === $plan)>{{ $plan }}</option>
                @endforeach
            </select>

            <label for="password">Password</label>
            <input id="password" name="password" type="password" required>

            <label for="password_confirmation">Confirm password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required>

            <button type="submit">Register</button>
        </form>
        <a class="text-link" href="{{ route('login') }}">Already have an account?</a>
        </section>
    </main>
</body>
</html>