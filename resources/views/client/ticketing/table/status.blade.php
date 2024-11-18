@php
$class = match ($ticket->status) { 'used' => 'bg-completed',  'unused' => 'bg-upcoming',  default => '' };
@endphp
<span class="event-status text-uppercase {{ $class }}">{{ $ticket->status }}</span>
