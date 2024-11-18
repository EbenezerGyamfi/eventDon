@extends('layout.client')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card contact-groups">
                <div class="card-header d-flex flex-row justify-content-between">
                    <h4 class="card-title"> Contact Groups </h4>


                    <a href="{{ route('contacts.groups.create') }}"
                        class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions">Add
                        Contact Group
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-people-fill" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            <path fill-rule="evenodd"
                                d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
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
            if ($(element).attr('data-contact-id')) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Are you sure you want to delete this contact group ?',
                    icon: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#e79d0f'
                })
                .then( (result) => {
                    if(result.isConfirmed) {
                        // $.ajax(route('contact'), {
                            
                        // })
                    }
                });
            }
        });
    </script>
@endpush
