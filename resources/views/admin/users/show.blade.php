@extends('layout.admin')

@section('style')
    <style>
        .status {
            border-radius: 3px;
            font-size: 8px;
        }

        .verified {
            background: rgba(5, 151, 5, 0.27);
            color: green;
        }

        .not-verified {
            background: rgba(255, 0, 0, 0.222);
            color: red;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex col-sm-6 juistify-content-center gap-1 pb-3 ">
                                <small>Name : </small>
                                <h6>{{ $user->name }}</h6>
                            </div>

                            <div class="d-flex col-sm-6 juistify-content-center gap-1 pb-3 ">
                                <small>Created At : </small>
                                <h6>{{ $user->created_at }}</h6>
                            </div>
                            <div class="d-flex col-sm-6 juistify-content-center gap-1 pb-3 ">
                                <small>Email :
                                </small>
                                <h6 class="d-flex juistify-content-center  gap-1">{{ $user->email }}
                                    @if ($user->email_verified)
                                        <small class="fw-bolder p-1 status verified">verified</small>
                                    @else
                                        <small class="fw-bolder p-1 status not-verified">Not verified</small>
                                    @endif
                                </h6>
                            </div>
                            <div class="d-flex col-sm-6 juistify-content-center gap-1 pb-3 ">
                                <small>Phone :
                                </small>
                                <h6 class="d-flex juistify-content-center gap-1">{{ $user->phone }}
                                    @if ($user->phone_number_verified)
                                        <small class="fw-bolder p-1 status verified">verified</small>
                                    @else
                                        <small class="fw-bolder p-1 status not-verified">Not verified</small>
                                    @endif
                                </h6>
                            </div>
                            <div class="d-flex col-sm-6 juistify-content-center gap-1 pb-3 ">
                                <small>Current Wallet Balance :
                                </small>
                                <h6 class="d-flex juistify-content-center gap-1">
                                    GHC {{ $user->mainWallet?->balance }}
                                </h6>
                            </div>
                        </div>

                        <hr>

                        <div class="events-details">
                            <h5>Events</h5>
                            <div class="table-responsive overflow-auto">
                                {{ $dataTable->table(['class' => 'table w-100']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
