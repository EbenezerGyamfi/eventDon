@extends('layout.admin')

@section('nav-elements')
    <ul class="navbar-nav" style="margin-left: 30%">
        <li class="nav-item btn-rotate dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-md" aria-hidden="true"></i>
                <p>
                    <span class="d-lg-none d-md-block">My Section</span>
                </p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Profile</a>
                <a class="dropdown-item" href="#">Logout</a>
            </div>
        </li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card-body ">
                <div class="card-header">
                    <ul class="nav nav-pills nav-pills-primary nav-pills-icons nav-justified justify-content-center"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#details" role="tablist">
                                <i class="now-ui-icons objects_umbrella-13"></i>
                                Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#questions" role="tablist">
                                <i class="now-ui-icons shopping_shop"></i>
                                Questions
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content tab-space tab-subcategories">
                    <div class="event-details tab-pane active container-fluid mt-5" id="details">
                        <div class="card p-3">
                            <div class="row">
                                <div class="col-sm-4 pt-5 mt-3">
                                    <img style="width: 500px;height: 200px;" src="{{ asset('img/party-people.png') }}"
                                        alt="Event Image">
                                </div>
                                <div class="col-sm-8">
                                    <h3 class="text-center font-weight-bold mt-2">{{ $event->name }}</h3>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row pt-3">
                                                <div class="col-12 row">
                                                    <span class="inline-block mr-5* col">
                                                        <i class="fa fa-hashtag" aria-hidden="true"></i>
                                                        {{ $event->ussdExtension?->code }}
                                                    </span>
                                                    <div class="col">

                                                        <span
                                                            class="inline-block event-status bg-{{ $event->status }}">{{ $event->status }}</span>

                                                    </div>
                                                </div>

                                                <div class="row mt-4 col-12">
                                                    <div class="col-sm-6* col">
                                                        {{ $event->questions_count }}
                                                        Question{{ $event->questions_count != 1 ? 's' : '' }}
                                                    </div>
                                                    <div class="col-sm-6* col">
                                                        {{ $event->answers_count }}
                                                        Answer{{ $event->answers_count != 1 ? 's' : '' }}
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-sm-6">


                                            <div class="inline-block* pt-3">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                {{ $event->venue }}
                                            </div>


                                            <div class="mt-4 d-flex">

                                                @if ($event->start_time->toDateString() === $event->end_time->toDateString())
                                                    <div
                                                        class="d-flex flex-row account-actions justify-content-center align-items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" fill="currentColor" class="bi bi-calendar-week"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                        </svg>
                                                        <div>
                                                            {{ $event->start_time->toDateString() }}
                                                        </div>


                                                        <div
                                                            class="d-flex flex-row account-actions justify-content-center align-items-center mx-3">

                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-clock"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                                                <path
                                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                                            </svg>

                                                            <div>
                                                                {{ $event->start_time->toTimeString() }} -
                                                                {{ $event->end_time->toTimeString() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">

                                                        <div
                                                            class="col-12 d-flex flex-row account-actions justify-content-left align-items-center pb-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                height="20" fill="currentColor"
                                                                class="bi bi-calendar-week" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                                                <path
                                                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                            </svg>
                                                            <div>
                                                                {{ $event->start_time->toDateString() }} -
                                                                {{ $event->end_time->toDateString() }}
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="col-12 d-flex flex-row account-actions justify-content-left align-items-center pb-3">

                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-clock"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                                                <path
                                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                                            </svg>
                                                            <div>
                                                                {{ $event->start_time->toTimeString() }} -
                                                                {{ $event->end_time->toTimeString() }}
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endif
                                            </div>

                                        </div>


                                        <div class="col-12 pt-5">
                                            <div class="d-flex justify-content-between align-items-center">

                                                <div> <b>{{ $event->attendees_count }}</b>
                                                    Attendee{{ $event->attendees_count != 1 ? 's' : '' }} so far </div>
                                                {{-- <span class="progress-badge">Expected attendees</span> --}}

                                            </div>
                                            <div class="progress-container progress-primary pr-1">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-primary pr-1" role="progressbar"
                                                        aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: {{ $attendanceProgress }}%;">
                                                        <span class="progress-value">{{ $attendanceProgress }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            @if (!is_null($event->program_lineup))
                                                <div class="mt-5">
                                                    <a href="{{ $programLineUpLink }}">Click here to download program line
                                                        up</a>
                                                </div>
                                            @endif

                                            @if ($event->can_pre_register)
                                                <div class="mt-5">
                                                    Pre-registration USSD code :<span class="inline-block mr-5* col">
                                                        <i class="fa fa-hashtag" aria-hidden="true"></i>
                                                        {{ $event->preRegistrationUssdExtension?->code }}
                                                    </span>
                                                </div>
                                            @endif
                                            @if ($event->ticketing)
                                                <div class="mt-5">
                                                    Ticketing USSD code :<span class="inline-block mr-5* col">
                                                        <i class="fa fa-hashtag" aria-hidden="true"></i>
                                                        {{ $event->ticketingUssdExtension?->code }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="mt-5 pt-3">
                                <h5>Messages</h3>
                                    <div class="row ">

                                        <div class="col-sm-6">
                                            <h6>Greeting Message</h6>
                                            <p>{{ $event->greeting_message }}</p>
                                        </div>

                                        <div class="col-sm-6">
                                            <h6>Goodbye Message</h6>
                                            <p>{{ $event->goodbye_message }}</p>
                                        </div>
                                    </div>
                            </div>

                            <div class="mt-5 pt-3">
                                <h5>Plan</h3>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6>Subscribed Plan</h6>
                                            <p>{{ $event->plan->name }}</p>
                                        </div>

                                        <div class="col-sm-3">
                                            <h6>Total SMS Credits</h6>
                                            <p>{{ $smsCredits }}</p>
                                        </div>

                                        <div class="col-sm-3">
                                            <h6>Remaining SMS credits</h6>
                                            <p>{{ $remainingSmsCredits }}</p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="questions">
                        <div class="card">
                            <div class="card-body p-4">
                                <h4 class="h4">All questions</h4>
                                <form>
                                    @foreach ($event->questions as $question)
                                        <div class="row my-5">
                                            <div class="col-md-4 mb-3">
                                                <div class="form-floating">
                                                    <input id="q-title" disabled="" class="form-control"
                                                        type="text" placeholder="Enter your value here!">
                                                    <label for="q-title">
                                                        <b> Question title :
                                                            {{ $question->title }}</b>
                                                    </label>
                                                    <!---->
                                                </div>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <div class="form-floating">
                                                    <input id="question" disabled="" class="form-control"
                                                        type="text" placeholder="Enter your value here!">
                                                    <label for="question">
                                                        <b> Question : {{ $question->question }}</b>
                                                    </label>
                                                    <!---->
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
    </div>
@endsection
