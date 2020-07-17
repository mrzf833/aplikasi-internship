<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="{{ asset('images/icon/logo.png') }}" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ request()->Is('student') ? 'active' : '' }}">
                    <a href="{{ route('student.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                <li class="{{ request()->Is('student/project*') ? 'active' : '' }}">
                    <a href="{{ route('student.project.index') }}">
                        <i class="fas fa-book"></i>Project</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>