<ul class="nav nav-pills nav-pills-primary justify-content-between" role="tablist">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('events.show', $event->id) }}" role="tablist" aria-expanded="true">
            Details
        </a>
    </li>


    @if (auth()->user()->role == 'client')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('events.show.questions', $event->id) }}" role="tablist"
                aria-expanded="false">
                Questions
            </a>
        </li>

        @if ($event->ask_pre_registration_questions)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('events.show.pre-registration-questions', $event->id) }}" role="tablist"
                    aria-expanded="false">
                    Pre-Registration Questions
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('events.show.pre-registered-attendees', $event->id) }}" role="tablist"
                    aria-expanded="false">
                    Pre-Registered Attendees
                </a>
            </li>
        @endif
    @endif


    <li class="nav-item">
        <a class="nav-link" href="{{ route('events.show.attendees', $event->id) }}" role="tablist"
            aria-expanded="false">
            Attendees
        </a>
    </li>


    @if ($event->type == 'funeral')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('events.donations.index', $event->id) }}" role="tablist"
                aria-expanded="false">
                Donations
            </a>
        </li>
    @endif
</ul>
