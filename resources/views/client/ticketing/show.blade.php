@extends('layout.client')

@section('content')
    <div class="ticket-details">
        @include('partials.events.ticket-tabs')

        <div class="container-fluid mt-5">
            <div class="card p-3">
                <div class="row">
                    <div class="col-sm-4">
                        <img src="{{ asset('img/event-details1.svg') }}" alt="Event Image">
                    </div>
                    <div class="col-sm-8">
                        <h3 class="text-center font-weight-bold mt-2">{{ $event->name }}</h3>

                        <div class="row">

                            <div class="col-sm-12">
                                <div class="col-12 row">
                                    <div class="col-sm-6">
                                        <span class="inline-block mr-5* col">
                                            <i class="fa fa-hashtag" aria-hidden="true"></i>
                                            {{ $event->ticketingUssdExtension->code }}
                                        </span>
                                    </div>

                                    <div class="col-sm-6">

                                        <span class="inline-block event-status bg-{{ $event->status }}">
                                            {{ $event->status }}
                                        </span>

                                    </div>
                                </div>
                            </div>



                            <div class="col-12 pt-5">

                                <div class="progress-container progress-primary pr-1">
                                    <span class="font-weight-bolder">
                                        {{ $totalSales }}GHC</span> <small class="pl-3">Sales So
                                        Far</small>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary pr-1" role="progressbar"
                                            aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                            style="width: {{ $salesPercentage }}%;">
                                            <span class="progress-value">{{ $salesPercentage }} % </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>




            </div>


            <div class="card p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3>Sales</h3>


                    <a class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions"
                        href="{{ route('ticket.verifyTicket', $event->id) }}">
                        Verify Ticket
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive overflow-auto">

                        {{ $dataTable->table(['class' => 'table w-100']) }}

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Verification modal --}}
    <div class=" modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verify Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Code">Code</label>
                        <input type="number" class="form-control" id="code" placeholder="Enter Code" name="code"
                            value="{{ old('code') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
