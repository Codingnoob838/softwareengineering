<button class="sidebar-toggle" type="button" aria-controls="admin-sidebar" aria-expanded="false" data-sidebar-toggle>
    <span aria-hidden="true">☰</span>
    <span class="sr-only">Open admin menu</span>
</button>

<div class="sidebar-backdrop" data-sidebar-close></div>
<aside class="admin-sidebar" id="admin-sidebar" aria-label="Admin navigation">
    <div class="sidebar-brand">
        <p class="eyebrow">D'Fitness Gym</p>
        <strong>Admin menu</strong>
    </div>
    <nav class="sidebar-nav">
        <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="sidebar-link {{ request()->routeIs('admin.memberships') ? 'is-active' : '' }}" href="{{ route('admin.memberships') }}">Membership status</a>
        <a class="sidebar-link {{ request()->routeIs('admin.members', 'admin.members.edit', 'admin.members.update') ? 'is-active' : '' }}" href="{{ route('admin.members') }}">Manage members</a>
        <a class="sidebar-link {{ request()->routeIs('admin.check-ins') ? 'is-active' : '' }}" href="{{ route('admin.check-ins') }}">Member check-ins</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="sidebar-link sidebar-logout" type="submit">Log out</button>
        </form>
    </nav>
</aside>

<script>
    const sidebar = document.querySelector('.admin-sidebar');
    const toggle = document.querySelector('[data-sidebar-toggle]');
    const closeButtons = document.querySelectorAll('[data-sidebar-close]');

    const closeSidebar = () => {
        sidebar.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
    };

    toggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.toggle('is-open');
        toggle.setAttribute('aria-expanded', String(isOpen));
    });

    closeButtons.forEach((button) => button.addEventListener('click', closeSidebar));
</script>