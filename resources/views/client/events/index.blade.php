@extends('layout.client')

@section('content')
    @include('partials.toast')
    <div>
        @if (auth()->user()->role == 'client')
            {{-- //Summary cards --}}
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body py-4">
                            <div class="row">
                                <div class="col-5 col-md-4 card-resize">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-globe text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8 card-resize">
                                    <div class="numbers">
                                        <p class="card-category">Total <br class="card-breaker d-none"> Events</p>
                                        <p class="card-title">{{ $statistics['total_events'] }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body py-4">
                            <div class="row">
                                <div class="col-5 col-md-4 card-resize">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-money-coins text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8 card-resize">
                                    <div class="numbers">
                                        <p class="card-category">Ongoing <br class="card-breaker d-none"> Events</p>
                                        <p class="card-title">{{ $statistics['ongoing_events'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body py-4">
                            <div class="row">
                                <div class="col-5 col-md-4 card-resize">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-minimal-up text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8 card-resize">
                                    <div class="numbers">
                                        <p class="card-category text-nowrap">Upcoming <br class="card-breaker d-none">
                                            Events</p>
                                        <p class="card-title">{{ $statistics['upcoming_events'] }}</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-body py-4">
                            <div class="row">
                                <div class="col-5 col-md-4 card-resize">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-favourite-28 text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8 card-resize">
                                    <div class="numbers">
                                        <p class="card-category">First <br class="card-breaker d-none"> Events</p>
                                        <p class="card-title">{{ $statistics['first_for_users_events'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- //Events Table --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header d-flex flex-row justify-content-between">
                            <h4 class="card-title"> Events </h4>

                            @if (auth()->user()->role == 'client')
                                <a href="{{ route('events.create') }}"
                                    class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions">Create
                                    an Event

                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive overflow-auto">

                            {{ $dataTable->table(['class' => 'table w-100']) }}

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="{{ mix('js/events.js') }}"></script>
@endpush
