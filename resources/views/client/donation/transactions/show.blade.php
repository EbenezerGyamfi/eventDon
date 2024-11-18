@extends('layout.client')
@section('script')
@endsection
@section('content')
    @include('partials.toast')
    <section>
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
                                    <p class="card-category card-wrap">Total Expected Amount</p>
                                    <p class="card-title"><small>&#8373;</small> {{ number_format ($transactions->whereIn('status', ['success', 'pending'])->sum ('amount_after_charges'), 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h6>{{ $page_title }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped dataTable">
                                <thead>
                                <tr>
                                    <th>Transaction ID</th>
{{--                                    <th>Amount</th>--}}
                                    <th>Amount</th>
                                    <th>Amount After Charges</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Status Message</th>
                                    <th>Recorded At</th>
                                    <th>Updated At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->transaction_id }}</td>
                                        <td>{{ number_format ($transaction->amount, 2) }}</td>
                                        <td>{{ number_format ($transaction->amount_after_charges, 2) }}</td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>{{ ucwords ($transaction->status) }}</td>
                                        <td>{{ $transaction->status_message }}</td>
                                        <td>{{ $transaction->created_at->format ('Y-m-d H:i:s') }}</td>
                                        <td>{{ $transaction->updated_at->format ('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
