<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/style.css')
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="page-shell dashboard-shell">
        <header class="dashboard-header">
            <div>
                <p class="eyebrow">D'Fitness Gym / Admin</p>
                <h1>Operations dashboard.</h1>
                <p class="muted">Approve members, monitor attendance, and keep the gym moving.</p>
            </div>
        </header>

        @if (session('success'))
            <div class="success" role="status">{{ session('success') }}</div>
        @endif

        <section class="stats-grid">
            <article class="stat-card stat-card-accent"><span>Pending accounts</span><strong>{{ $pendingMembers->count() }}</strong><small>Awaiting review</small></article>
            <article class="stat-card"><span>Active members</span><strong>{{ $members->where('approval_status', 'approved')->count() }}</strong><small>Approved accounts</small></article>
            <article class="stat-card"><span>Today's check-ins</span><strong>{{ $todayCheckIns }}</strong><small>Recorded visits</small></article>
        </section>

        <section class="panel" id="pending-accounts">
            <div class="panel-heading"><div><p class="eyebrow">Approval queue</p><h2>Pending member accounts</h2></div></div>
            @forelse ($pendingMembers as $member)
                <div class="member-row">
                    <div><strong>{{ $member->name }}</strong><small>{{ $member->email }} · Joined {{ $member->created_at->format('M d, Y') }}</small></div>
                    <form method="POST" action="{{ route('admin.members.approve', $member) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Approve account</button>
                    </form>
                </div>
            @empty
                <p class="empty-state">No accounts are waiting for approval.</p>
            @endforelse
        </section>

    </main>
</body>
</html>