<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Events Don
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" /> --}}
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />

    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Primary Meta Tags -->
    <meta name="title" content="Events Don - 'Boss' up your events!">
    <meta name="description"
        content="@yield('meta_description', 'If you\'re planning an event, make it easy with EventsDon. With EventsDon, you can easily track who is coming to your event, manage your attendees, know what they are donating, give them customized messages, and collect valuable data from them.')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ config('app.url') }}" />
    <meta property="og:title" content="Events Don - 'Boss' up your events!" />
    <meta property="og:description"
        content="@yield('meta_description', 'If you\'re planning an event, make it easy with EventsDon. With EventsDon, you can easily track who is coming to your event, manage your attendees, know what they are donating, give them customized messages, and collect valuable data from them.')">
    <meta property="og:image" content="/meta.png" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{ config('app.url') }}" />
    <meta property="twitter:title" content="Events Don - 'Boss' up your events!" />
    <meta property="twitter:image" content="{{ asset('/meta.png') }}" />

    <meta name="facebook-domain-verification" content="pkxs0cil8tl72a4kk8neojv7v5j7na" />
    <meta name="facebook-domain-verification" content="pkxs0cil8tl72a4kk8neojv7v5j7na" />
    <meta name="facebook-domain-verification" content="pkxs0cil8tl72a4kk8neojv7v5j7na" />
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WD77XHYB2M"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-WD77XHYB2M');
    </script>
    <!-- Meta Pixel Code -->
    <meta name="facebook-domain-verification" content="pkxs0cil8tl72a4kk8neojv7v5j7na" />

    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '742416453632101');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=742416453632101&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

</head>

<style>
    body {
        background: rgb(0, 0, 0);
        background: linear-gradient(180deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0.7455182756696428) 0%), url('https://bit.ly/3MHBdNT ');
        background-repeat: no-repeat;
        background-size: cover;
        height: 100vh
    }

    main {
        /* height: 93.9vh */
    }


    .arkesel-logo {
        width: 100px
    }

    @media screen and (max-width:380px) {
        .remember-me {
            flex-direction: column !important;
            justify-content: center !important;
        }
    }

</style>



<body>

    <main class="content-main">
        @yield('page_header')
        <div class="container pt-5 ">
            <div class="col-12 col-md-9 col-lg-5 ml-auto mr-auto mt-4 pt-5 mt-5">
                @yield('content')
            </div>
        </div>
        </div>
    </main>






    @routes
    @include('partials.tawk')
    <!--   Core JS Files   -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>


    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"
        integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])

    @stack('scripts')

</body>

</html>
