<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Members</title>
    @vite('resources/css/style.css')
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="page-shell dashboard-shell">
        <header class="dashboard-header">
            <div>
                <p class="eyebrow">D'Fitness Gym / Member accounts</p>
                <h1>Manage members.</h1>
                <p class="muted">Update or remove registered member accounts.</p>
            </div>
        </header>

        @if (session('success'))
            <div class="success" role="status">{{ session('success') }}</div>
        @endif

        <section class="panel" id="member-accounts">
            <div class="panel-heading"><div><p class="eyebrow">Member accounts</p><h2>{{ $members->count() }} registered members</h2></div></div>
            @forelse ($members as $member)
                <div class="member-row">
                    <div><strong>{{ $member->name }}</strong><small>{{ $member->email }} · {{ ucfirst($member->approval_status) }}</small></div>
                    <div class="member-actions">
                        <a class="button button-small button-quiet" href="{{ route('admin.members.edit', $member) }}">Manage</a>
                        <form method="POST" action="{{ route('admin.members.remove', $member) }}" onsubmit="return confirm('Delete this member account?')">
                            @csrf
                            @method('DELETE')
                            <button class="button-danger button-small" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="empty-state">No member accounts found.</p>
            @endforelse
        </section>
    </main>
</body>
</html>