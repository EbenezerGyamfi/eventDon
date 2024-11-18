@extends('layout.client')


@section('content')
    <div>
        <div class="card sms-campaign">
            <div class="row pt-2 align-items-center">
                <div class="col-sm-6">
                    <div class="chart-container w-100 position-relative">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
                <div class="col-sm-6 details">
                    <h3>Campaign Details</h3>
                    <div class="table-responsive overflow-auto">
                        <table class="table">
                            <tr>
                                <td>Event</td>
                                <td>{{ $campaign->event->name }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ $campaign->status }}</td>
                            </tr>
                            <tr>
                                <td>Number of Recipients</td>
                                <td>{{ $campaign->sms_histories_count }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-header d-flex flex-row justify-content-between">
                <h4 class="card-title">Recipients</h4>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        window.stats = @json($stats);
    </script>
    <script src="{{ mix('js/sms-campaign.js') }}"></script>
@endpush
