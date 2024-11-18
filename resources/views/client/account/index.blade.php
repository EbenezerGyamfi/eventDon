@extends('layout.client')

@section('content')
    @include('partials.toast')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-row justify-content-between">
                    <h4 class="card-title"> Account</h4>


                    <a href="{{ route('accounts.create') }}"
                        class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions">Add


                        An Account


                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-window-plus" viewBox="0 0 16 16">
                            <path
                                d="M2.5 5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1ZM4 5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1Zm2-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0Z" />
                            <path
                                d="M0 4a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v4a.5.5 0 0 1-1 0V7H1v5a1 1 0 0 0 1 1h5.5a.5.5 0 0 1 0 1H2a2 2 0 0 1-2-2V4Zm1 2h13V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2Z" />
                            <path
                                d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 0 0 1 0v-1h1a.5.5 0 0 0 0-1h-1v-1a.5.5 0 0 0-.5-.5Z" />
                        </svg>
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
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        var table = $('.table');
        table.on('click', function(event) {
            var element = event.target;
            if ($(element).attr('data-item-id')) {
                Swal.fire({
                        text: 'Are you sure you want to delete this account ?',
                        icon: 'warning',
                        showCancelButton: true,
                        reverseButtons: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        confirmButtonColor: '#e79d0f'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = route('accounts.destroy', $(element).attr('data-item-id'));
                        }
                    });
            }
        });
    </script>
@endpush
