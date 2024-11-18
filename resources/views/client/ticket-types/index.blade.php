@extends('layout.client')

@section('content')
    <div class="ticket-details">
        @include('partials.events.ticket-tabs')
        @include('partials.toast')

        <div class="event-ticket-types">
            <div class="card mt-5">
                <div class="card-header">
                    <div class="card-header d-flex flex-row justify-content-between">
                        <h4 class="card-title"> Ticket Types </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive overflow-auto">

                        {{ $dataTable->table(['class' => 'table w-100 event-ticket-types-table']) }}

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@include('client.ticket-types.edit')


@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="{{ mix('js/event-ticketing.js') }}"></script>
@endpush
