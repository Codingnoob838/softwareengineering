<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Member</title>
    @vite('resources/css/style.css')
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="page-shell">
        <section class="auth-card manage-card">
            <a class="text-link" href="{{ route('admin.dashboard') }}">← Back to admin dashboard</a>
            <p class="eyebrow">Member account</p>
            <h1>Manage {{ $member->name }}</h1>

            @if ($errors->any())
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.members.update', $member) }}">
                @csrf
                @method('PUT')

                <label for="name">Full name</label>
                <input id="name" name="name" type="text" value="{{ old('name', $member->name) }}" required>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $member->email) }}" required>

                <label for="approval_status">Account approval</label>
                <select id="approval_status" name="approval_status" required>
                    @foreach (['pending', 'approved', 'rejected'] as $status)
                        <option value="{{ $status }}" @selected(old('approval_status', $member->approval_status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>

                <label for="plan">Membership plan</label>
                <input id="plan" name="plan" type="text" value="{{ old('plan', $membership?->plan ?? 'Monthly') }}" required>

                <label for="membership_status">Membership status</label>
                <select id="membership_status" name="membership_status" required>
                    @foreach (['pending', 'active', 'expired', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected(old('membership_status', $membership?->status ?? 'pending') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>

                <label for="starts_at">Membership starts</label>
                <input id="starts_at" name="starts_at" type="date" value="{{ old('starts_at', $membership?->starts_at?->format('Y-m-d')) }}">

                <label for="ends_at">Membership ends</label>
                <input id="ends_at" name="ends_at" type="date" value="{{ old('ends_at', $membership?->ends_at?->format('Y-m-d')) }}">

                <button type="submit">Save member account</button>
            </form>
        </section>
    </main>
</body>
</html>