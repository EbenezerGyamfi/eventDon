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
                        <h6>{{ $data['page_title'] }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info font-weight-bold" style="font-size: 14px">
                            Note: The gifts feature is only limited to ongoing paid events (events with more than 30 expected attendees)
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Event Title</th>
                                        <th>Expected Attendees</th>
                                        <th>Attendance</th>
                                        <th>Gift Entries</th>
                                        <th>Total Gifts Quantity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($events as $event)
                                    <tr>
                                        <td>{{ $event->name }}</td>
                                        <td>{{ $event->expected_attendees }}</td>
                                        <td>{{ $event->attendees->count () }}</td>
                                        <td>{{ $event->giftsEntriesCount () }}</td>
                                        <td>{{ $event->giftsCount () }}</td>
                                        <td>
                                            @if($event->status === 'ongoing' && $event->expected_attendees > 30)
                                                <a href="{{ route ('gifts.create', $event) }}" class="btn btn-success btn-sm">Receive Gifts <span class="fa fa-arrow-right"></span></a>
                                            @endif
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
