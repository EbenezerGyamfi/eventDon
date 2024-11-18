@extends('layout.client')

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-row justify-content-between">
                    <h4 class="card-title">

                        <a href="{{ route('contacts.groups.show', $contact_group->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                            </svg> <b>{{ $contact_group->name }}</b></a>
                    </h4>

                    <div class="d-flex flex-row account-actions">


                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 py-5">
                        <div class="text-center">
                            <a href="{{ route('contacts.import.download') }}"> Download required Sample format <i
                                    class="fa fa-download" aria-hidden="true"></i></a>
                        </div>
                        <h5 class="text-center">Import Contacts By File (csv.xlsx)</h5>

                        <form id="send-sms-file-form" role="form" method="post"
                            action="{{ route('contacts.groups.import', [$contact_group->id]) }}"
                            enctype="multipart/form-data" class="col-md-6 mx-auto">
                            @csrf

                            <div class="input-group col-6*">
                                <div class="custom-file">
                                    <input type="file" name="contacts" id="contacts" class="custom-file-input my-5 form-control"
                                        required
                                        accept=".csv, text/html, .xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">

                                    <label class="custom-file-label" id="contacts-label" for="contacts"
                                        >Choose file</label>
                                </div>

                            </div>
                            <div class="text-center">

                                <button type="submit" id="submitContact" class="btn btn-info px-5">
                                    import <i class="fa fa-download" aria-hidden="true"></i>
                                </button>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script>
            var fileInput = $('#contacts');

            fileInput.on('change', function(event) {
                file = fileInput[0].files[0];
                console.log(file);

                if(file) {
                    $('#contacts-label').text(file.name);
                } else {
                    $('#contacts-label').text('Choose File');   
                }
            });
        </script>
    @endpush
