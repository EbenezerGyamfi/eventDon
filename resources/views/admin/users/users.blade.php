@extends('layout.admin')

@section('nav-elements')
@endsection

@section('content')
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Users </h4>
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
@endpush
