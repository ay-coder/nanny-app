<!-- Header Start -->
<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="/">
                <img src="{!! asset('frontend/images/white_logo.png') !!}" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbar">
                <ul class="navbar-nav">
                    @if ($logged_in_user)
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('frontend.user.sitter.dashboard') }}">Home</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.aboutus') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.services') }}">Services</a>
                    </li>
                    @if (! $logged_in_user)
                    <!-- Before Login Start -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.auth.login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('frontend.auth.register') }}">Register</a>
                        </li>
                    @endif
                    <!-- Before Login End -->
                    <!-- After Login Start -->
                    @if ($logged_in_user)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{ access()->user()->name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('frontend.user.sitter.earning') }}">My Jobs</a>
                                <a class="dropdown-item" href="{{ route('frontend.user.sitter.account') }}">My Profile<span class="status"></span></a>
                                <a class="dropdown-item" href="{{ route('frontend.user.sitter.earning') }}">My Earning</a>
                                <a class="dropdown-item" href="{{ route('frontend.user.sitter.vacation') }}">Vacation Mode</a>
                                <a class="dropdown-item" href="{{ route('frontend.user.sitter.notification') }}">Notification</a>
                                <a class="dropdown-item" href="{{ route('frontend.auth.logout') }}">Logout</a>
                            </div>
                        </li>
                    @endif
                    <!-- After Login End -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.contactus') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </nav><!-- Navigation End -->
    </div><!-- Container End -->
</header>
<!-- Header End -->