@extends('layout.client')

@section('content')
    <div class="events-details">
        @include('partials.events.tabs')
        @include('partials.toast')

        <div class="event-questions">
            <div class="card mt-5">
                <div class="card-header">
                    <div class="card-header d-flex flex-row justify-content-between">
                        <h4 class="card-title"> Pre-Registration Questions </h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive overflow-auto">

                        {{ $dataTable->table(['class' => 'table w-100 event-questions-table']) }}

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@include('client.questions.edit')

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="{{ mix('js/events.js') }}"></script>
@endpush
