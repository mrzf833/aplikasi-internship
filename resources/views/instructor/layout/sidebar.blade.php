<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="{{ asset('images/icon/logo.png') }}" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ request()->Is('instructor') ? 'active' : '' }}">
                    <a href="{{ route('instructor.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                <li class="{{ request()->Is('instructor/review-student*') ? 'active' : '' }}">
                    <a href="{{ route('instructor.review_student.index') }}">
                        <i class="fas fa-users"></i>Review Student</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>