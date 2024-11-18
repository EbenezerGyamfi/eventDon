@extends('layout.client')



@section('content')
    {{-- //Summary cards --}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body py-4">
                    <div class="row">
                        <div class="col-5 col-md-4 card-resize">
                            <div class="icon-big text-center icon-warning"> <i
                                    class="nc-icon nc-money-coins text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8 card-resize">
                            <div class="numbers">
                                <p class="card-category card-wrap">Total <br class="card-breaker d-none"> Donations</p>
                                <p class="card-title"><small>&#8373;</small> {{ $statistics['total_donations'] }}</p>

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
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-calendar-week text-secondary" viewBox="0 0 16 16">
                                    <path
                                        d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                </svg>
                            </div>
                        </div>
                        <div class="col-7 col-md-8 card-resize">
                            <div class="numbers">
                                <p class="card-category card-wrap">Total <br class="card-breaker d-none"> Events</p>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-calendar-event text-primary" viewBox="0 0 16 16">
                                    <path
                                        d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                </svg>
                            </div>
                        </div>
                        <div class="col-7 col-md-8 card-resize">
                            <div class="numbers">
                                <p class="card-category card-wrap">Ongoing <br class="card-breaker d-none"> Events</p>
                                <p class="card-title">{{ $statistics['total_ongoing_events'] }}</p>

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
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-calendar2-plus text-warning" viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H2z" />
                                    <path
                                        d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V4zM8 8a.5.5 0 0 1 .5.5V10H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V11H6a.5.5 0 0 1 0-1h1.5V8.5A.5.5 0 0 1 8 8z" />
                                </svg>
                            </div>
                        </div>
                        <div class="col-7 col-md-8 card-resize">
                            <div class="numbers">
                                <p class="card-category card-wrap text-nowrap">Upcoming <br class="card-breaker d-none">
                                    Events</p>
                                <p class="card-title">{{ $statistics['total_upcoming_events'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    {{-- Tables --}}

    <div class="col-md-12">
        <div class="card">
            <div class="card-header row">
                <div class="col">
                    @if (auth()->user()->role == 'client')
                        <h4 class="card-title"> All Donations</h4>
                    @else
                        <h4 class="card-title"> My Transactions</h4>
                    @endif
                </div>
                <div class="col-auto">
                    <a href="{{ route('donation-transactions.index') }}" class="btn btn-primary">Donation Transaction <i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive overflow-auto">

                    {{ $dataTable->table(['class' => 'table w-100']) }}

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
