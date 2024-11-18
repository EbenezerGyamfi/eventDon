<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
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
    <meta property="twitter:card" content="summary_large_image">
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
    <title>
        Events Don
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    @yield('style')
</head>

<style>
    .pointer {
        cursor: pointer;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: rgb(102, 97, 91);
    }


    .card .avatar {
        width: 100px;
        height: 100px;
        overflow: hidden;
        border-radius: 50%;
        margin-bottom: 15px;
        border: 1px solid rgb(154, 154, 154);
    }


    .account-actions {
        gap: 10px
    }

    .btn-gb {
        background: rgb(231, 157, 15)
    }

    .actions-btn {
        border-radius: 50%;
    }

    .view {
        background: #51ccce2d
    }

    .edit {
        background: #6c757d36
    }

    .view-icon {
        color: #2fdfe3
    }

    .edit-icon {
        color: #3e4449
    }

    .delete-icon {
        color: #e7100b
    }

    .delete {
        background: rgba(255, 0, 0, 0.185)
    }

    .table> :not(caption)>*>* {

        border-bottom-width: inherit !important;
    }

    .dropdown {
        position: relative;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        left: 5%;
        right: 5%;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    } */


    @media (min-width:1200px) and (max-width:1365px) {
        .card-stats {
            height: 9em;
        }

        .card-category {
            white-space: normal !important;
        }
    }



    @media (min-width:576px) and (max-width:607px) {
        .card-stats {
            height: 7em;
        }

        .card-category {
            white-space: normal !important;
        }
    }
</style>


<body style="background: #f4f3ef;">
    <div class="wrapper ">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                <a href="https://www.creative-tim.com" class="simple-text logo-normal">
                    <div class="logo-image-big">
                        <svg width="160" height="30" viewBox="0 0 160 30" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M26.8889 0H3.11111C1.39289 0 0 1.39289 0 3.11111V26.8889C0 28.6071 1.39289 30 3.11111 30H26.8889C28.6071 30 30 28.6071 30 26.8889V3.11111C30 1.39289 28.6071 0 26.8889 0Z"
                                fill="#0D3B66" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.66669 7.55554H22.884C23.2549 7.55554 23.5556 7.85623 23.5556 8.22714C23.5556 9.6181 22.428 10.7457 21.0371 10.7457H7.55558C7.06466 10.7457 6.66669 10.3477 6.66669 9.85679V7.55554ZM8.16793 13.3728H19.1309C19.5018 13.3728 19.8025 13.6735 19.8025 14.0444C19.8025 15.4354 18.6749 16.5629 17.284 16.5629H9.05682C8.56589 16.5629 8.16793 16.165 8.16793 15.6741V13.3728ZM22.1334 19.1901H8.16793V21.4913C8.16793 21.9823 8.56589 22.3802 9.05682 22.3802H20.2864C21.6774 22.3802 22.8049 21.2527 22.8049 19.8617C22.8049 19.4908 22.5042 19.1901 22.1334 19.1901Z"
                                fill="#E79D0F" />
                            <path
                                d="M40.6666 19.9111H46.8889V23.3333H37.1111V7.77779H46.7777V11.2H40.6666V13.7778H46.2222V17.1556H40.6666V19.9111ZM52.406 23.3333L47.3393 7.77779H51.2282L54.6726 19.2222L58.1171 7.77779H62.006L56.9393 23.3333H52.406ZM66.6762 19.9111H72.8984V23.3333H63.1206V7.77779H72.7873V11.2H66.6762V13.7778H72.2317V17.1556H66.6762V19.9111ZM83.3489 7.77779H86.9044V23.3333H84.2377L78.2377 14.8889V23.3333H74.6822V7.77779H77.3489L83.3489 16.2222V7.77779ZM99.7917 7.77779V11.2H95.7917V23.3333H92.2362V11.2H88.2362V7.77779H99.7917ZM106.136 23.6445C104.551 23.6445 103.225 23.3038 102.158 22.6222C101.107 21.9259 100.358 20.9852 99.914 19.8L102.981 18.0222C103.603 19.4593 104.692 20.1778 106.247 20.1778C107.655 20.1778 108.358 19.7556 108.358 18.9111C108.358 18.4519 108.129 18.0963 107.67 17.8445C107.225 17.5778 106.381 17.2741 105.136 16.9333C104.484 16.7556 103.914 16.5556 103.425 16.3333C102.936 16.1111 102.455 15.8222 101.981 15.4667C101.522 15.0963 101.166 14.6371 100.914 14.0889C100.677 13.5407 100.558 12.9111 100.558 12.2C100.558 10.763 101.07 9.61483 102.092 8.75556C103.129 7.8963 104.358 7.46667 105.781 7.46667C107.055 7.46667 108.181 7.77039 109.158 8.37779C110.136 8.97039 110.907 9.83705 111.47 10.9778L108.47 12.7333C108.188 12.1407 107.84 11.6963 107.425 11.4C107.01 11.0889 106.462 10.9333 105.781 10.9333C105.247 10.9333 104.833 11.0519 104.536 11.2889C104.255 11.5111 104.114 11.7852 104.114 12.1111C104.114 12.4963 104.292 12.8296 104.647 13.1111C105.018 13.3926 105.773 13.7037 106.914 14.0445C107.536 14.2371 108.018 14.3926 108.358 14.5111C108.699 14.6296 109.129 14.8296 109.647 15.1111C110.181 15.3778 110.581 15.6667 110.847 15.9778C111.129 16.2741 111.373 16.6741 111.581 17.1778C111.803 17.6667 111.914 18.2296 111.914 18.8667C111.914 20.3482 111.381 21.5185 110.314 22.3778C109.247 23.2222 107.855 23.6445 106.136 23.6445Z"
                                fill="#0D3B66" />
                            <path
                                d="M119.691 7.77779C121.839 7.77779 123.632 8.52594 125.069 10.0222C126.521 11.5037 127.246 13.3482 127.246 15.5556C127.246 17.763 126.521 19.6148 125.069 21.1111C123.632 22.5927 121.839 23.3333 119.691 23.3333H113.469V7.77779H119.691ZM119.691 19.9111C120.921 19.9111 121.913 19.5185 122.669 18.7333C123.439 17.9333 123.824 16.8741 123.824 15.5556C123.824 14.2371 123.439 13.1852 122.669 12.4C121.913 11.6 120.921 11.2 119.691 11.2H117.024V19.9111H119.691ZM142.179 21.3111C140.609 22.8667 138.698 23.6445 136.446 23.6445C134.194 23.6445 132.283 22.8667 130.712 21.3111C129.142 19.7556 128.357 17.8371 128.357 15.5556C128.357 13.2741 129.142 11.3556 130.712 9.80001C132.283 8.24445 134.194 7.46667 136.446 7.46667C138.698 7.46667 140.609 8.24445 142.179 9.80001C143.749 11.3556 144.534 13.2741 144.534 15.5556C144.534 17.8371 143.749 19.7556 142.179 21.3111ZM133.201 18.8889C134.075 19.7482 135.157 20.1778 136.446 20.1778C137.734 20.1778 138.809 19.7482 139.668 18.8889C140.542 18.0296 140.979 16.9185 140.979 15.5556C140.979 14.1926 140.542 13.0815 139.668 12.2222C138.809 11.363 137.734 10.9333 136.446 10.9333C135.157 10.9333 134.075 11.363 133.201 12.2222C132.342 13.0815 131.912 14.1926 131.912 15.5556C131.912 16.9185 132.342 18.0296 133.201 18.8889ZM154.981 7.77779H158.536V23.3333H155.87L149.87 14.8889V23.3333H146.314V7.77779H148.981L154.981 16.2222V7.77779Z"
                                fill="#E79D0F" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <x-sidenav-list-item :route="route('admin.home')">
                        <a href="{{ route('admin.home') }}">
                            <i class="nc-icon nc-bank"></i>
                            <p>Home</p>
                        </a>
                    </x-sidenav-list-item>
                    <x-sidenav-list-item :route="route('admin.events.index')">
                        <a href="{{ route('admin.events.index') }}">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <p>Events</p>
                        </a>
                    </x-sidenav-list-item>

                    <x-sidenav-list-item :route="route('admin.users.index')">
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            <p>Users</p>
                        </a>
                    </x-sidenav-list-item>

                    <x-sidenav-list-item route="#">
                        <a href="#">
                            <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                            <p>Subscriptions</p>
                        </a>
                    </x-sidenav-list-item>

                    <x-sidenav-list-item :route="route('admin.transactions.index')">
                        <a href="{{ route('admin.transactions.index') }}">
                            <i class="fa fa-money"></i>
                            <p>Transactions</p>
                        </a>
                    </x-sidenav-list-item>

                    <x-sidenav-list-item route="#" class="dropdown">
                        <a href="#" class="dropbtn">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                            <p>Report</p>

                            <div class="dropdown-content">
                                <a href="#">Link 1</a>
                                <a href="#">Link 2</a>
                                <a href="#">Link 3</a>
                            </div>
                        </a>
                    </x-sidenav-list-item>
                    <x-sidenav-list-item route="#">
                        <a href="#">
                            <i class="bi bi-gear"></i>
                            <p>Settings</p>
                        </a>
                    </x-sidenav-list-item>




                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <p class="navbar-brand">{{ $page_title ?? '' }}</p>
                    </div>

                    <button class="navbar-toggler border-none" type="button" data-toggle="collapse"
                        data-target="#navigation" aria-controls="navigation-index" aria-expanded="false"
                        aria-label="Toggle navigation">

                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                            class="bi bi-list " viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                        </svg>


                    </button>

                    <div class="collapse navbar-collapse justify-content-end" id="navigation"
                        style="background-color: #f4f3ef;">
                        <ul class="navbar-nav d-flex flex-column justify-content-center align-items-center d-lg-none">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.events.index') }}">
                                    Events
                                </a>
                            </li>
                            <li class="nav-item">

                                <a class="nav-link" href="{{ route('admin.users.index') }}">
                                    Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.profile.show') }}">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"
                                    onclick="document.getElementById('logout-form').submit()">Logout</a>

                                <form action="{{ route('logout') }}" method="post" id="logout-form">
                                    @csrf
                                </form>
                            </li>
                        </ul>



                        <ul class="navbar-nav d-none d-lg-block">
                            {{-- @yield('nav-elements') --}}
                            <li class="nav-item btn-rotate dropdown">
                                <a class="nav-link dropdown-toggle*" href="http://example.com"
                                    id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">

                                    <span id="name"
                                        class="navbar-toggler-bar bg-secondary text-white font-weight-bolder d-flex justify-content-center align-items-center p-2 rounded-circle"
                                        style="width: 50px; height:50px;">

                                    </span>

                                </a>
                                <div class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('admin.profile.show') }}">Profile</a>
                                    <a class=" dropdown-item" href="#"
                                        onclick="document.getElementById('logout-form').submit()">Logout</a>
                                    <form action="{{ route('logout') }}" method="post" id="logout-form">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <main class="content">
                <div class="row">
                    <div class="col-md-12">
                        @yield('page_header')
                        @yield('content')

                    </div>
                </div>
            </main>


        </div>
    </div>

    @include('partials.tawk')

    <!--   Core JS Files   -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>

    <script>
        const name = (@json(auth()->user()->name))

        document.querySelector("#name").innerHTML =
            `${name.split(" ")[0].substr(0, 1)} ${name.split(" ")[1].substr(0, 1)}`
    </script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('script')
    @stack('scripts')
</body>

</html>
