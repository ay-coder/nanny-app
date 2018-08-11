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
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about-us.html">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="services.html">Services</a>
                    </li>
                    <!-- Before Login Start -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Login</a>
                    </li>
                    <!-- Before Login End -->
                    <!-- After Login Start -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Username
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="myappointment.html">My Appointment</a>
                            <a class="dropdown-item" href="myprofile.html">My Profile <span class="status"></span></a>
                            <a class="dropdown-item" href="subscriptions.html">Subscriptions</a>
                            <a class="dropdown-item" href="notification.html">Notification</a>
                            <a class="dropdown-item" href="support.html">Support</a>
                            <a class="dropdown-item" href="index.html">Logout</a>
                        </div>
                    </li>
                    <!-- After Login End -->
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact</a>
                    </li>
                </ul>
            </div>
        </nav><!-- Navigation End -->
        <div class="banner-tagline">
            <span>Book A Sitter</span>
        </div><!-- Banner End-->
    </div><!-- Container End -->
</header>
<!-- Header End -->