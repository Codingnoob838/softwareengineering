<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    @vite('resources/css/style.css')
</head>
<body>
    <main class="page-shell dashboard-shell">
        <header class="dashboard-header">
            <div>
                <p class="eyebrow">D'Fitness Gym / Member portal</p>
                <h1>Good to see you, {{ $member->name }}.</h1>
                <p class="muted">Your training, membership, and check-ins in one place.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="button button-quiet" type="submit">Log out</button>
            </form>
        </header>

        @if (session('success'))
            <div class="success" role="status">{{ session('success') }}</div>
        @endif

        <nav class="dashboard-tabs" aria-label="Member dashboard sections">
            @foreach (['overview' => 'Overview', 'membership' => 'Membership', 'check-ins' => 'Check-ins', 'qr-pass' => 'QR Pass'] as $tab => $label)
                <a class="dashboard-tab {{ $activeTab === $tab ? 'is-active' : '' }}" href="{{ route('dashboard', ['tab' => $tab]) }}" @if ($activeTab === $tab) aria-current="page" @endif>{{ $label }}</a>
            @endforeach
        </nav>

        @if ($activeTab === 'overview')
            <section class="stats-grid">
                <article class="stat-card stat-card-accent"><span>Membership</span><strong>{{ ucfirst($membership?->status ?? 'pending') }}</strong><small>{{ $membership?->plan ?? 'Awaiting approval' }}</small></article>
                <article class="stat-card"><span>Valid until</span><strong>{{ $membership?->ends_at?->format('M d, Y') ?? 'Not active' }}</strong><small>Keep your membership current</small></article>
                <article class="stat-card"><span>Member status</span><strong>{{ ucfirst($member->approval_status) }}</strong><small>{{ $member->email }}</small></article>
            </section>

            <section class="dashboard-grid">
                <article class="panel">
                    <div class="panel-heading"><div><p class="eyebrow">Quick actions</p><h2>Keep moving</h2></div></div>
                    <div class="action-list">
                        <a class="action-item" href="{{ route('dashboard', ['tab' => 'check-ins']) }}"><span>01</span>View check-in history <b>→</b></a>
                        <a class="action-item" href="{{ route('dashboard', ['tab' => 'membership']) }}"><span>02</span>View membership status <b>→</b></a>
                        <a class="action-item" href="{{ route('dashboard', ['tab' => 'qr-pass']) }}"><span>03</span>Open real QR pass <b>▦</b></a>
                    </div>
                </article>
                <article class="panel qr-mini-panel">
                    <div class="panel-heading"><div><p class="eyebrow">Your member pass</p><h2>Ready to scan</h2></div><img class="qr-mini" src="{{ $qrDataUri }}" alt="Member QR code"></div>
                    <p class="muted">Open the QR Pass tab to display or download your real member code.</p>
                </article>
            </section>
        @elseif ($activeTab === 'membership')
            <section class="panel tab-panel">
                <p class="eyebrow">Membership status</p>
                <h2>{{ ucfirst($membership?->status ?? 'pending') }}</h2>
                <p class="muted">{{ $membership?->plan ?? 'Your membership is waiting for admin approval.' }}</p>
                <div class="membership-detail"><span>Starts</span><strong>{{ $membership?->starts_at?->format('M d, Y') ?? 'Pending approval' }}</strong></div>
                <div class="membership-detail"><span>Expires</span><strong>{{ $membership?->ends_at?->format('M d, Y') ?? 'Not active' }}</strong></div>
            </section>
        @elseif ($activeTab === 'check-ins')
            <section class="panel tab-panel">
                <p class="eyebrow">Recent activity</p>
                <h2>Check-in history</h2>
                @forelse ($attendance as $record)
                    <div class="history-row"><span>{{ $record->checked_in_at->format('M d, Y') }}</span><span>{{ $record->checked_in_at->format('g:i A') }}</span><b>{{ ucfirst($record->source) }}</b></div>
                @empty
                    <p class="empty-state">No check-ins yet. Your next visit will appear here.</p>
                @endforelse
            </section>
        @else
            <section class="panel qr-pass-panel tab-panel">
                <div>
                    <p class="eyebrow">Digital member pass</p>
                    <h2>Your real QR code</h2>
                    <p class="muted">Gym staff can scan this code to identify your member account.</p>
                    <code class="member-id">MEMBER-{{ str_pad((string) $member->id, 5, '0', STR_PAD_LEFT) }}</code>
                    <a class="button qr-download" href="{{ $qrDataUri }}" download="dfitness-member-{{ $member->id }}.svg">Download QR code</a>
                </div>
                <img class="qr-code" src="{{ $qrDataUri }}" alt="Real QR code for {{ $member->name }}">
            </section>
        @endif
    </main>
</body>
</html>
