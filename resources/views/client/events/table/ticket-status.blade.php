@php


    $class = match( strtoupper($event->status)) {


        'USED' => 'bg-completed',
        'UNUSED' => 'bg-upcoming',
         default => ''
    }

@endphp
<span class="event-status {{$class}}">{{$event->status}}</span>
