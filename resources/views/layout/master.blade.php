<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- STYLES -->
    <!-- CSS only -->
    <link type="text/css" href="{{ asset('css/homepage.css') }}" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- ICONS AND FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>{{ config('app.name') }}</title>


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


    <meta name="title" content="EventsDon - Make your event a success with EventsDon">
    <meta name="description"
        content="With EventsDon, you can manage your events with a wide range of services and tools. From event attendance to ticketing platforms, EventsDon has got you covered. We also offer cloud communication tools such as USSD, SMS, Voice Message, and many more.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="EventsDon - Make your event a success with EventsDon">
    <meta property="og:description"
        content="With EventsDon, you can manage your events with a wide range of services and tools. From event attendance to ticketing platforms, EventsDon has got you covered. We also offer cloud communication tools such as USSD, SMS, Voice Message, and many more.">
    <meta property="og:image" content="{{ asset('/meta.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary">
    <meta property="twitter:url" content="{{ config('app.url') }}">
    <meta property="twitter:title" content="EventsDon - Make your event a success with EventsDon">
    <meta property="twitter:description"
        content="Events Don puts the fun back in event planning. With an easy-to-use interface and innovative features, Events Don allows you to create, post, and promote your event, all from the convenience of your computer">
    <meta property="twitter:image" content="{{ asset('/meta.png') }}">


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
</head>

<style>
    html {
        scroll-behavior: smooth;
    }

    .deepOrange{
        color: #e79d0f !important;
    }

    .btn-outline-deepOrange {
        border-color: #e79d0f;
        color: #e79d0f !important;

    }

    .btn-outline-deepOrange:hover {
        background: #e79d0f;
        color: white !important;
    }

    /* event-card */
    .event-card:hover{
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .10) !important;
        border-radius: 15px;
        cursor: pointer;
    }
    /* end of event-card css */
    .pricing li:before {
        content: '✓';
        margin-right: 10px
    }

    .pricing-card:hover {
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }

    .moreButton {
    font-weight: 900 !important;
}

    @media only screen and (min-width:768px) {
        .features-card {
            height: 14.5em;
            max-height: 15em;
        }
    }


    @media only screen and (min-width:992px) {
        .features-card {
            height: 14em;
            max-height: 15em;
        }
    }

    .form-control:focus {
        outline: none !important;
    }


    .form-control:focus {
        border-color: inherit;
        -webkit-box-shadow: none;
        box-shadow: none;
    }


    @media only screen and (max-width:520px) {
        .card-price {
            flex: 0 0 auto;
            width: 100%;
        }
    }


    .notifier {
        /* transition: display .8s linear; */
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        color: #fff;
        background: rgba(0, 0, 0, .9);
        z-index: 2000;
        transition: display .4s linear;
        animation: show 0.5s;
    }

    .notifier:not(.show) {
        display: none;
    }

    #video-container {
        width: calc(250px + 20%);
        height: 390px;
        background: #0d3b66;
        border-radius: 1rem !important;
        cursor: pointer;

    }

    .playButton {
        bottom: 20px;
        left: 20px;
    }

    @keyframes show {
        0% {
            transform: scale(0.95);
        }


        100% {
            transform: scale(1);
        }

    }



    @media (min-width:992px) and (max-width:1200px) {
        .inspired {
            margin-top: 3rem
        }
    }

    @media screen and (min-width:768px) {
        .powered {
            margin-right: -60px;
        }
    }
    
    /* media queries for supported events at mobile and tablet screens */
    @media only screen and (max-width:576px){
            .supported-event{
                display: flex;
                flex-direction: column;
                align-items:baseline;
                width: 100%;
                text-align: start;
                word-wrap: break-word;
            }
            .detail{
                display: flex;
                width: 100%;
            }
            .image{
                width: 100%;
                margin-bottom: 40px;
            }
            .heading{
                font-size: 20px;
            }
    }
    /* on tablet screens only */
    @media only screen and (min-width:577px) and (max-width:768px){
            .supported-event{
                display: flex;
                flex-direction: column;
                align-items:baseline;
                width: 100%;
                text-align: center;
                word-wrap: break-word;
            }
            .detail{
                display: flex;
                width: 100%;
            }
            .image{
                width: 100%;
                margin-bottom: 40px;
            }
    }
    /* on larger screens */
    @media only screen and (min-width:992px){
            .supported-event{
                display: flex;
                align-items:baseline;
                width: 100%;
                text-align: start;
                word-wrap: break-word;
            }
            .detail{
                display: flex;
                width: 50%;
            }
            .image{
                width: 50%;
            }
    }
</style>


<body>
    @include('partials.nav-bar')
    @yield('content')
    @include('partials.footer')
</body>

@include('partials.tawk')
<script>
    var pageScroll = ""
    window.addEventListener("scroll", () => {
        pageScroll = window.pageYOffset;
        //For navbar
        if (window.pageYOffset > 2) {
            document.getElementById("navbar").classList.add("onScrollBgColor");
            document.getElementById("navbar").classList.add("onScrollInputColor");
        } else {
            document.getElementById("navbar").classList.remove("onScrollBgColor");
            document
                .getElementById("navbar")
                .classList.remove("onScrollInputColor");
        }
    });



    const showNotifier = () => {
        document.querySelector(".notifier").classList.add("show");

    }

    const closeNotifier = () => {
        document.querySelector(".notifier").classList.remove("show");
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous" defer>
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>


@stack('scripts')


</html>
