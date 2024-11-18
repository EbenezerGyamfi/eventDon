@php
    $class = match($event->status) {
        'completed' => 'bg-completed',
        'upcoming' => 'bg-upcoming',
        'ongoing' => 'bg-ongoing',
        default => ''
    }
@endphp
<span class="event-status {{$class}}">{{$event->status}}</span>