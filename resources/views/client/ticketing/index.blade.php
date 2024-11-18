@extends('layout.client')


@section('script')
@endsection

@section('content')
    @include('partials.toast')

    <div>
        <div class="row">
            <div class="col-sm-6">
                <div class="card card-stats">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-5 col-md-4">


                                <div class="icon-big text-center icon-primary">
                                    <i class="nc-icon nc-credit-card text-primary"></i>


                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category"> Total Tickets Sales</p>
                                    <p class="card-title"><small>&#8373;</small>
                                        {{ $totalAmountSold }}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="fa fa-money text-warning" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category"> Sold Tickets</p>
                                    <p class="card-title"><small>&#8373;</small>
                                        0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-sm-6">
                <div class="card card-stats">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-secondary">
                                    <i class="fa fa-calendar-check-o text-secondary" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Total Events</p>
                                    {{ $eventsWithTicketingEnabled }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>


        {{-- //Events Table --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h4 class="card-title">Events</h4>

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

    <script src="{{ mix('js/scanner.js') }}"></script>
@endpush
