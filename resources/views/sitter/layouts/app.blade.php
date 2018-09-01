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

        {{ Html::style('frontend/css/bootstrap.min.css') }}
        {{ Html::style('frontend/css/bootstrap-datetimepicker.min.css') }}
        {{ Html::style('frontend/css/font-awesome.min.css') }}
        <link href="https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800|Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">

        <!-- Theme CSS -->
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
            @include('sitter.includes.nav')
            <section class="main-content">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            @include('includes.partials.messages')
                            @yield('content')
                        </div>
                    </div>
                </div><!-- container -->
            </section><!-- .main-content End -->
            @include('parent.includes.footer')
        </div><!--#app-->

        <!-- Scripts -->
        @yield('before-scripts')
        <script type="text/javascript" src="{!! asset('frontend/js/lib.min.js') !!}"></script>
        <script>
            var ModuleConfig = '';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        @yield('after-scripts')
        <script type="text/javascript" src="{!! asset('frontend/js/general.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('js/custom/custom.js') !!}"></script>
        <script type="text/javascript" src="{!! asset('frontend/js/nanny-app.js') !!}"></script>
        @yield('end-scripts')
        @include('includes.partials.ga')
    </body>
</html>