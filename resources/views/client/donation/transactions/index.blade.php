@extends('layout.client')
@section('script')
@endsection
@section('content')
    @include('partials.toast')
    <section>
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
                                    <th>Event Title</th>
                                    <th>Pending Transactions</th>
                                    <th>Failed Transactions</th>
                                    <th>Successful Transactions</th>
                                    <th>Total Transactions</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($events as $event)
                                    <tr>
                                        <td>{{ $event->name }}</td>
                                        <td>{{ number_format ($event->donationTransactions()->pending ()->count ()) }}</td>
                                        <td>{{ number_format ($event->donationTransactions()->failed ()->count ()) }}</td>
                                        <td>{{ number_format ($event->donationTransactions()->success ()->count ()) }}</td>
                                        <td>{{ number_format ($event->donationTransactions ()->count ()) }}</td>
                                        <td>
                                            <a href="{{ route ('donation-transactions.show', $event->id) }}" class="btn btn-success btn-sm">View Transactions <span class="fa fa-arrow-right"></span></a>
                                        </td>
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
