@extends('layout.master')

@section('content')

    <div class="
    d-flex 
    flex-column 
    container 
    w-100 
    h-auto
    "
    style="margin-top: 7rem"
    >
    <div class="d-flex flex-row flex-wrap gap-5 mt-5 w-full align-items-center justify-content-center">
        <img style="width:3rem"  src={{asset('img/workshop.svg')}} alt="workshop">
        <img style="width:3rem" src={{asset('img/wedding.svg')}} alt="wedding">
        <img style="width:3rem" src={{asset('img/funeral.svg')}} alt="funeral">
        <img style="width:3rem" src={{asset('img/cinema.svg')}} alt="cinema">
        <img style="width:3rem" src={{asset('img/plays.svg')}} alt="plays">
        <img style="width:3rem" src={{asset('img/dinner.svg')}} alt="dinner">
        <img style="width:3rem" src={{asset('img/graduation.svg')}} alt="graduation">
        <img style="width:3rem" src={{asset('img/product-launch.svg')}} alt="product-launch">
        <img style="width:3rem" src={{asset('img/celebration.svg')}} alt="celebration">
    </div>
        <h1 class="text-center mt-5 fs-1 heading">Built for any type of event, large or small</h1>
        <div class="d-flex flex-column align-items-center w-auto">

            {{-- first element --}}

            <div 
            class="
            d-lg-flex 
            flex-wrap 
            w-100 
            justify-content-between 
            align-items-center
            supported-event 
            "
            style="margin-top:6rem"
            id="workshop"
            >
                <div class=" d-flex align-items-center justify-content-center image">
                    <img style="width: 7rem"  src="{{asset('img/workshop.svg')}}" alt="workshop">
                </div>
                <div class="d-lg-flex flex-column  detail">
                    <h2 class="fw-normal  text-decoration-underline">Workshop/conferences/Seminars</h2>
                    <p class="fs-5 mt-3 fw-normal ">Keep track of who attended your workshop with our attendance tracking feature.
                        Send personalized messages to attendees of your workshop and say thanks.
                        Planning a workshop? Ask attendees to RSVP before the event.
                        Share your program lineup with attendees via a USSD Extension.
                    </p>
                </div>
            </div>

                        {{-- second element --}}
            
                        <div 
                        class="
                        d-lg-flex 
                        flex-wrap 
                        w-auto 
                        justify-content-between 
                        align-items-center 
                        supported-event
                        "
                        style="margin-top:6rem"
                        id="wedding"
                        >
                        <div class="image d-flex align-items-center justify-content-center">
                            <img style="width: 7rem"  src="{{asset('img/wedding.svg')}}" alt="workshop">
                        </div>
                        <div class="d-flex flex-column detail">
                            <h2 class="fw-normal  text-decoration-underline">Weddings</h2>
                            <p class="fs-5 mt-3 fw-normal ">Ask your family and friends to RSVP for your wedding. This helps with planning and budgeting.
                                Know who attended your wedding with our attendance tracking feature.
                                Share your wedding program line up electronically with EventsDon.
                                Send a thank you message to all those who attended your wedding.
                            </p>
                        </div>
                        </div>

                                    {{-- third element --}}
            
            <div 
            class="
            d-lg-flex
            flex-wrap 
            w-auto 
            justify-content-between 
            align-items-center 
            supported-event
            "
            style="margin-top:6rem"
            id="funeral"
            >
                <div class="image d-flex align-items-center justify-content-center">
                    <img style="width: 7rem"  src="{{asset('img/funeral.svg')}}" alt="workshop">
                </div>
                <div class="d-flex flex-column detail">
                    <h2 class="fw-normal  text-decoration-underline">Funerals</h2>
                    <p class="fs-5 mt-3 fw-normal ">Ask your family and friends to RSVP for the burial service. This helps with planning and budgeting.
                        Know who attended the funeral with our attendance tracking feature.
                        Share your service program line up electronically with EventsDon.
                        Send a thank you message to all those who came to support you in your bereavement.
                    </p>
                </div>
            </div>

                        {{-- fourth element --}}
            
                        <div 
                        class="
                        d-lg-flex 
                        flex-wrap 
                        w-auto 
                        justify-content-between 
                        align-items-center 
                        supported-event
                        "
                        style="margin-top:6rem"
                        id="cinema"
                        >
                        <div class="image d-flex align-items-center justify-content-center">
                            <img style="width: 7rem"  src="{{asset('img/cinema.svg')}}" alt="workshop">
                        </div>
                        <div class="d-flex flex-column detail">
                            <h2 class="fw-normal  text-decoration-underline">Concerts/Movie Premieres</h2>
                            <p class="fs-5 mt-3 fw-normal ">Sell & verify tickets online, on your phone or at the venue.
                                Attendance tracking for concerts hasn’t been this easy. Don't lose track of your audience.
                                Engage concert goers with personalized messages before, during & after an event.
                                Manage crowds effectively by asking concert goers to RSVP before the event.
                                Make your concert lineup easily accessible via USSD with EventsDon.
                            </p>
                        </div>
                        </div>

                                    {{-- fifth element --}}
            
            <div 
            class="
            d-lg-flex 
            flex-wrap 
            w-auto 
            justify-content-between 
            align-items-center 
            supported-event
            "
            style="margin-top:6rem"
            id="plays"
            >
                <div class="image d-flex align-items-center justify-content-center">
                    <img style="width: 7rem"  src="{{asset('img/plays.svg')}}" alt="workshop">
                </div>
                <div class="d-flex flex-column detail">
                    <h2 class="fw-normal  text-decoration-underline">Plays</h2>
                    <p class="fs-5 mt-3 fw-normal ">Sell tickets to your play and verify them at the venue with a QR Code, via your preferred payment provider.
                        Track & manage your attendees online and connect with them when the play is over with personalized follow up messages.
                        Make sure you never have an empty seat, ask attendees to RSVP for your plays.
                        Attendees can access features such as a program lineup, cast, sponsors etc. via USSD.
                </div>
            </div>

                        {{-- sixth element --}}
            
                        <div 
                        class="
                        d-lg-flex 
                        flex-wrap 
                        w-auto 
                        justify-content-between 
                        align-items-center 
                        supported-event
                        "
                        style="margin-top:6rem"
                        id="dinner"
                        >
                        <div class="image d-flex align-items-center justify-content-center">
                            <img style="width: 7rem"  src="{{asset('img/dinner.svg')}}" alt="workshop">
                        </div>
                        <div class="d-flex flex-column detail">
                            <h2 class="fw-normal  text-decoration-underline">Dinners</h2>
                            <p class="fs-5 mt-3 fw-normal ">Track attendance and number of guests who have made it to your dinner with your friends, family, colleagues or others.
                                Plan your dinners ahead of time. Ask your guests to RSVP in advance.
                                Send personalized thank you messages to guests to graced your dinner.
                            </p>
                        </div>
                        </div>

                                    {{-- seventh element --}}
            
            <div 
            class="
            d-lg-flex 
            flex-wrap 
            w-auto 
            justify-content-between 
            align-items-center 
            supported-event
            "
            style="margin-top:6rem"
            id="graduation"
            >
                <div class="image d-flex align-items-center justify-content-center">
                    <img style="width: 7rem"  src="{{asset('img/graduation.svg')}}" alt="workshop">
                </div>
                <div class="d-flex flex-column detail">
                    <h2 class="fw-normal  text-decoration-underline">Graduations</h2>
                    <p class="fs-5 mt-3 fw-normal ">Keep track and send personalized messages to family & friends that came to celebrate your big day with EventsDon.
                        Maintain a guest list for your graduation and ask family & friends to RSVP for your graduation.
                        Make is easy foe your guests to access the program lineup via a simple USSD Extension.
                    </p>
                </div>
            </div>

                        {{-- eigth element --}}
            
                        <div 
                        class="
                        d-lg-flex 
                        flex-wrap 
                        w-auto 
                        justify-content-between 
                        align-items-center 
                        supported-event
                        "
                        style="margin-top:6rem"
                        id="product"
                        >
                        <div class="image d-flex align-items-center justify-content-center">
                            <img style="width: 7rem"  src="{{asset('img/product-launch.svg')}}" alt="workshop">
                        </div>
                        <div class="d-flex flex-column detail">
                            <h2 class="fw-normal  text-decoration-underline">Product Launches</h2>
                            <p class="fs-5 mt-3 fw-normal ">Track attendance and collect leads during your product launch/activation with EventsDon
                                With EventsDon inbuilt Bulk SMS feature you can engage with customers before, during & after your product launch.
                            </p>
                        </div>
                        </div>

                                    {{-- ninth element --}}
            
            <div 
            class="
            d-lg-flex 
            flex-wrap 
            w-auto 
            justify-content-between 
            align-items-center 
            supported-event
            
            "
            style="margin-top:6rem
            "
            id="celebration"
            >
                <div class="image d-flex align-items-center justify-content-center">
                    <img style="width: 7rem"  src="{{asset('img/celebration.svg')}}" alt="workshop">
                </div>
                <div class="d-flex flex-column detail">
                    <h2 class="fw-normal  text-decoration-underline">Anniversary Celebrations</h2>
                    <p class="fs-5 mt-3 fw-normal ">With attendance tracking you can know who made it to your anniversary celebration.
                        Stay in touch with your guests long after the celebration is over with thoughtful messages.
                        Celebrate your anniversary with EventsDon. Ask all your guests to RSVP so you can plan in advance.
                    </p>
                </div>
            </div>
            <div style="margin-top: 6rem">
                
            </div>
        </div>
    </div>
@endsection