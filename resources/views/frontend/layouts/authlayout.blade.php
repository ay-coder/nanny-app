<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', app_name())</title>

        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'Nanny App')">
        <meta name="author" content="@yield('meta_author', 'Nanny App')">
        @yield('meta')

        <!-- Styles -->
        @yield('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->
        {{ Html::style('frontend/css/bootstrap.min.css') }}
        <link href="https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800|Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">
        {{ Html::style('frontend/css/styles.css') }}
        @yield('after-styles')

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
    </head>
    <body id="app-layout">
        <div id="app">
            <div class="login-container">
                <div class="login-signup-wrap">
                    <!-- Form Section Start -->
                    <div class="login-form">
                        <img src="{!! asset('frontend/images/grey_logo.png') !!}" alt="Five Stars Sitter">
                        <div class="form-wrap">
                            @include('includes.partials.messages')
                            @yield('content')
                        </div>

                        <div class="terms-conditions">
                            <a href="#">Terms & Conditions</a>
                        </div>
                    </div>
                    <!-- Form Section End -->
                    <!-- Content Area Start -->
                    <div class="full-bg">
                        <div class="full-bg-content">
                            <img src="{!! asset('frontend/images/fivestar-logo-1.png') !!}" alt="Five Stars Sitter" class="d-none d-md-block">
                            <h3>Caring For All That You Love</h3>
                            <p class="short-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <p class="copyright">&copy; Copyright Five Star Sitters. All Right Reserved. Contact Us: (702) 530-3229</p>
                        </div>
                    </div>
                    <!-- Content Area End -->
                </div><!-- .login-signup-wrap end -->
            </div><!-- login-container -->
        </div><!--#app-->

        <!-- Scripts -->
        @yield('before-scripts')
        @yield('after-scripts')
        <script type="text/javascript" src="{!! asset('frontend/js/lib.min.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('frontend/js/general.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/custom/custom.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('frontend/js/nanny-app.js') !!}"></script>
        @yield('end-scripts')
        @include('includes.partials.ga')
    </body>
</html>