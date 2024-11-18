<ul class="nav nav-pills nav-pills-primary nav-justified" role="tablist">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('ticketing.show', $event->id) }}" role="tablist" aria-expanded="true">
            Details
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('events.ticket-types.index', $event->id) }}" role="tablist"
            aria-expanded="false">
            Manage Tickets
        </a>
    </li>

</ul>

@push('scripts')
    <script>
        $(".ticket-details > ul.nav a.nav-link").each(function(index, element) {
            const url = window.location.href.split("?")[0];
            if (url === $(element).attr("href")) {
                $(element).addClass("active");
            }
        });
    </script>
@endpush
