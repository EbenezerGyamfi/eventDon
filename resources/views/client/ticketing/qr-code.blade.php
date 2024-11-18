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

    <!-- Primary Meta Tags -->
    <meta name="title" content="EventsDon - Make your event a success with EventsDon">
    <meta name="description"
        content="With EventsDon, you can manage your events with a wide range of services and tools. From event attendance to ticketing platforms, EventsDon has got you covered. We also offer cloud communication tools such as USSD, SMS, Voice Message, and many more.">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="EventsDon - Make your event a success with EventsDon">
    <meta property="og:description"
        content="With EventsDon, you can manage your events with a wide range of services and tools. From event attendance to ticketing platforms, EventsDon has got you covered. We also offer cloud communication tools such as USSD, SMS, Voice Message, and many more.">
    <meta property="og:image" content="/meta.png">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ config('app.url') }}">
    <meta property="twitter:title" content="EventsDon - Make your event a success with EventsDon">
    <meta property="twitter:description"
        content="With EventsDon, you can manage your events with a wide range of services and tools. From event attendance to ticketing platforms, EventsDon has got you covered. We also offer cloud communication tools such as USSD, SMS, Voice Message, and many more.">
    <meta property="twitter:image" content="/meta.png">
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
    @stack('css')
</head>


<style>
    body {
        background: linear-gradient(180deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 0.3) 0%), url({{ asset('assets/img/eventsdon_qr_code.png') }});
        background-repeat: no-repeat;
        background-size: cover;
        min-height: 100vh;
        background-position: bottom;
    }

    .logo-image-big {
        top: 30px
    }

    .event-details {
        width: 13em;
        background: rgba(255, 255, 255, 0.295);
    }


    @media (min-width:400px) {
        #qr-bg {
            width: 22em;
        }
    }
</style>

<body>
    <main>
        <div class="container-fluid">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <header>
                    <div class="logo-image-big position-relative mx-auto">
                        <img src="{{ asset('img/eventsdon.svg') }}" alt="qrcode" style="width: 20em">
                </header>
                <div class="mt-5 pt-3 mx-auto">
                    <div class="d-flex justify-content-center align-items-center" id="qr-code">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <div class="bg-white mb-3 text-center py-4" id="qr-bg">
                                {{-- <img src="https://bit.ly/3NK8ZlD" alt="qrcode" class="img-fluid"> --}}
                                {!! QrCode::size(300)->generate($ticket->code) !!}
                            </div>
                            <p
                                class="mt-0 pt-0 text-center text-white h5 event-details py-2 rounded font-weight-bolder">
                                x{{ $ticket->no_of_tickets }} {{ $ticket->ticketType->name }} tickets
                            </p>
                            <p
                                class="mt-0 pt-0 text-center text-white h5 event-details py-2 rounded font-weight-bolder">
                                {{ $ticket->event->name }}
                            </p>
                            <p
                                class="mt-0 pt-0 text-center text-white h5 event-details py-2 rounded font-weight-bolder">
                                {{ $ticket->event->venue }}
                            </p>
                            <p
                                class="mt-0 pt-0 text-center text-white h5 event-details py-2 rounded font-weight-bolder">
                                <span> {{ $ticket->event->start_time->format('l, F j, Y') }}
                                </span> <span>{{ $ticket->event->start_time->format('H:i A') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
