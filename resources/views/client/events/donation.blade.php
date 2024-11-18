@extends('layout.client')

@section('content')
    <div class="events-details">
        @include('partials.toast')

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
                                    <p class="card-category card-wrap">Total Donations</p>
                                    <p class="card-title"><small>&#8373;</small> {{ number_format ($totalDonations, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header">
                        <div class="card-header d-flex flex-row justify-content-between">
                            <h4 class="card-title"> All Donations </h4>

                            @if (auth()->user()->role != 'client')
                                <a href="{{ route('events.donations.create', $event->id) }}"
                                   class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions">
                                    <i class="nc-icon nc-money-coins"></i>
                                    Receive Donation
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
