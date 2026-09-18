<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Check-ins</title>
    @vite('resources/css/style.css')
</head>
<body>
    @include('admin.partials.sidebar')

    <main class="page-shell dashboard-shell">
        <header class="dashboard-header">
            <div>
                <p class="eyebrow">D'Fitness Gym / Attendance</p>
                <h1>Member check-ins.</h1>
                <p class="muted">See which member accounts visited the gym and how they checked in.</p>
            </div>
        </header>

        <section class="panel membership-table-panel">
            <div class="panel-heading">
                <div>
                    <p class="eyebrow">Attendance records</p>
                    <h2>{{ $checkIns->count() }} recorded check-ins</h2>
                </div>
            </div>

            <div class="membership-table-wrap">
                <table class="membership-table">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checkIns as $checkIn)
                            <tr>
                                <td><strong>{{ $checkIn->user?->name ?? 'Deleted member' }}</strong></td>
                                <td>{{ $checkIn->user?->email ?? '—' }}</td>
                                <td>{{ $checkIn->checked_in_at->format('M d, Y') }}</td>
                                <td>{{ $checkIn->checked_in_at->format('g:i A') }}</td>
                                <td><span class="status-pill status-approved">{{ ucfirst($checkIn->source) }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty-state">No member check-ins recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>