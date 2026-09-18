<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Status</title>
    @vite('resources/css/style.css')
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="page-shell dashboard-shell">
        <header class="dashboard-header">
            <div>
                <a class="text-link" href="{{ route('admin.dashboard') }}">← Back to admin dashboard</a>
                <p class="eyebrow">D'Fitness Gym / Memberships</p>
                <h1>Membership status.</h1>
                <p class="muted">Review every member's current plan and validity.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="button button-quiet" type="submit">Log out</button>
            </form>
        </header>

        <section class="panel membership-table-panel">
            <div class="panel-heading">
                <div>
                    <p class="eyebrow">Member accounts</p>
                    <h2>Membership status</h2>
                </div>
                <span class="member-count">{{ $members->count() }} members</span>
            </div>

            <div class="membership-table-wrap">
                <table class="membership-table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Valid from</th>
                            <th>Valid until</th>
                            <th>Account</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            @php($membership = $member->memberships->first())
                            <tr>
                                <td><strong>{{ $member->name }}</strong><small>{{ $member->email }}</small></td>
                                <td>{{ $membership?->plan ?? 'Not assigned' }}</td>
                                <td><span class="status-pill status-{{ $membership?->status ?? 'pending' }}">{{ ucfirst($membership?->status ?? 'pending') }}</span></td>
                                <td>{{ $membership?->starts_at?->format('M d, Y') ?? '—' }}</td>
                                <td>{{ $membership?->ends_at?->format('M d, Y') ?? '—' }}</td>
                                <td><span class="status-pill status-{{ $member->approval_status }}">{{ ucfirst($member->approval_status) }}</span></td>
                                <td><a class="button button-small button-quiet" href="{{ route('admin.members.edit', $member) }}">Manage</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="empty-state">No member accounts found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>