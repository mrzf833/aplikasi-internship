<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="{{ asset('images/icon/logo.png') }}" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                <li class="has-sub {{ request()->is('admin/*') ? 'active' : '' }}">
                    <a class="js-arrow d-flex" href="#">
                        <i class="fas fa-users mt-auto mb-auto"></i><div class="mb-auto mt-auto">Data Master</div><i class="fas fa-arrow-right ml-auto mt-auto mb-auto rotate-0"></i>
                    </a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}">Users</a>
                        </li>
                        <li class="{{ request()->is('admin/mentors*') ? 'active' : '' }}">
                            <a href="{{ route('admin.mentors.index') }}">Mentors</a>
                        </li>
                        <li class="{{ request()->is('admin/instructors*') ? 'active' : '' }}">
                            <a href="{{ route('admin.instructors.index') }}">Instructors</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>