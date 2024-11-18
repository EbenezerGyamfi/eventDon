
    @extends('layout.master')
    @section('content')
    <main class="position-relative">
        <div class="container position-relative">
            <x-home-page-head />
            <x-features />
            <x-demo />
            <x-about-us />
            <x-pricing />
            <x-supported-events/>
        </div>
        <x-contact/>
    </main>
    @endsection




