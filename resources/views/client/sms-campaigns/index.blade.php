@extends('layout.client')

@section('content')
    @include('partials.toast')

    <div>
        
        <div class="card">
            <div class="card-header d-flex flex-row justify-content-between">
                <h4 class="card-title">SMS Campaign Reports</h4>
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
@endpush
