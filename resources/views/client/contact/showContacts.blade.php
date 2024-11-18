@extends('layout.client')

@section('content')
    @include('partials.toast')
    <div class="row">
        <div class="col-12">
            <div class="card contact-groups">
                <div class="card-header d-flex flex-row justify-content-between">
                    <h4 class="card-title"><b>{{ $contact_group->name }}</b> <small>Contacts</small></h4>

                    <div class="flex-row account-actions action-buttons">
                        <button
                            class="d-flex flex-row justify-content-center align-items-center account-actions btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#addNumber">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-person-plus" viewBox="0 0 16 16">
                                <path
                                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                <path fill-rule="evenodd"
                                    d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                            </svg>

                            Add Contact </button>

                        <a href="{{ route('contacts.import.view', ['id' => $contact_group->id]) }}"
                            class="btn  btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions"
                            id="upload">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-cloud-download" viewBox="0 0 16 16">
                                <path
                                    d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z" />
                                <path
                                    d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z" />
                            </svg>
                            <b>import Contacts</b>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive overflow-auto">

                        <table class="table" id="contacts">
                            <thead class=" text-primary">
                                <tr>
                                    </th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th class="text-center">Action </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="addNumber" tabindex="-1" aria-labelledby="addNumberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNumberModalLabel">Add New Contact</h5>
                    <a href="#" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> <i
                            class="fa fa-times" aria-hidden="true"></i></a>
                </div>
                <form action="{{ route('add.contact') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group required">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" required="" name="phone" value="">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="">
                        </div>
                        <input type="hidden" name="contact_group_id" value="{{ $contact_group->id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Add <i class="fa fa-check"
                                    aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- {{ $dataTable->scripts() }} --}}


    <script>
        document.getElementById('upload').addEventListener('click', () => {
            document.getElementById('upload-contact').click()
        })


        // const sweet = () => {
        //     Swal.fire(
        //         'Good job!',
        //         'You clicked the button!',
        //         'success'
        //     )
        // }
    </script>

    <script>
        $(document).ready(function() {

            $('#contacts').DataTable({
                processing: true,
                language: {
                    processing: '<span>Processing</span>',
                },
                serverSide: true,
                ajax: "{{ route('group.contacts.table', $contact_group->id) }}",
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'actions'
                    },
                ]
            });


        });
    </script>
    {{-- <script>
    $(document).ready(function() {
        $('#hasContactGroup').click(function() {
            if ($(this).val() == ('true') && $(this).is(':checked')) {
                $('#contactGroup').show();
            } else {
                $('#contactGroup').hide();
            }
        });
    });
</script> --}}
@endpush
