@if (session('message'))
@php
    toast(session('message'), 'success');
@endphp
@endif

@if (session('error'))
@php
    toast(session('error'), 'error');
@endphp
@endif

@error('error')
    @php
         toast($message, 'error');
    @endphp
@enderror