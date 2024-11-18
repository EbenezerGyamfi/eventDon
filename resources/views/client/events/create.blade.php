@extends('layout.client')
@push('css')
    <style>
        .select2-container .select2-selection--single {
            height: 40px;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #DDDDDD;
            padding-top: 3px;
        }
    </style>
@endpush
@section('content')
    @include('partials.toast')
    <form action="{{ route('events.store') }}" method="POST" id="create-event-form">
        @csrf
        <div class="card p-3 ">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Event Details</h5>

                <a href="{{ route('wallet-events.index') }}"
                    class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions">
                    Top Up Account
                </a>
            </div>

            <div class="form-row">
                <div class="col-sm-6 form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror py-3" name="name"
                        id="name" placeholder="Enter event name" value="{{ old('name') }}">
                    <span class="invalid-feedback">error</span>

                </div>

                <div class="col-sm-6 form-group">
                    <label for="venue">Venue</label>
                    <input type="text" class="form-control @error('venue') is-invalid @enderror py-3" name="venue"
                        id="venue" placeholder="Enter event venue" value="{{ old('venue') }}">
                    <span class="invalid-feedback">error</span>

                </div>
            </div>
            <div class="form-row mt-3">

                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="start_time">Start Time</label>
                            <input type="text" onfocus="this.type='datetime-local'"
                                class="form-control @error('start_time') is-invalid @enderror py-3" name="start_time"
                                id="start_time">
                            <span class="invalid-feedback">error</span>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="end_time">End Time</label>
                            <input type="text" onfocus="this.type='datetime-local'"
                                class="form-control @error('end_time') is-invalid @enderror py-3" name="end_time"
                                id="end_time">
                            <span class="invalid-feedback">error</span>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="expected_attendees">Expected Number of Attendees</label>
                    <input type="number" class="form-control py-3" name="expected_attendees" id="expected_attendees"
                        value="{{ old('expected_attendees') }}">
                    <span class="invalid-feedback">error</span>
                    <label for="expected_attendees" class="text-center text-danger">EventsDon is free for events with 30 or
                        fewer
                        attendees. All event
                        registrations above your plan
                        limit
                        are not saved. Access our plans <a href="/#pricing">here</a></label>
                </div>

            </div>

            <div class="form-row pt-4">
                <div class="col-sm-6 form-group">
                    <label for="type">Select Event Type</label>
                    <select name="type" class="form-control py-3" id="type">
                        <option value="other">Other</option>
                        <option value="funeral">Funeral</option>
                    </select>
                    <span class="invalid-feedback">error</span>
                </div>

                <div class="col-sm-6">
                    <label for="program_lineup">Upload Program Lineup</label>
                    <div>
                        <label for="program_lineup" class="file-label d-block btn btn-outline-primary mt-0">Click to upload
                            program line up</label>
                        <input type="file" class="d-none" name="program_lineup" id="program_lineup">
                        <span class="invalid-feedback">error</span>
                    </div>
                </div>
            </div>

            <div class="form-row" id="tellers">
                <div class="col-sm-6 form-group">
                    <label for="assigned_users">Assign Tellers To Event</label>
                    <select style="width: 100%" id="assigned_users" class="form-control py-3" multiple>
                    </select>
                    <span class="invalid-feedback">error</span>
                </div>
            </div>

        </div>


        <div class="card p-3 mt-5">
            <h5>Greeting Messages</h5>
            <div class="form-row">
                <div class="col-sm-6 form-group">
                    <label for="greeting_message">Greeting Message</label>
                    <textarea class="form-control @error('greeting_message') is-invalid @enderror" name="greeting_message"
                        id="greeting_message" placeholder="Enter Greeting Message">{{ old('greeting_message') }}</textarea>
                    <span class="invalid-feedback">error</span>
                </div>

                <div class="col-sm-6 form-group">
                    <label for="venue">Goodbye Message</label>
                    <textarea name="goodbye_message" id="goodbye_message"
                        class="form-control @error('greeting_message') is-invalid @enderror" placeholder="Enter Goodbye Message">{{ old('goodbye_message') }}</textarea>
                    <span class="invalid-feedback">error</span>
                </div>
            </div>

            <div class="mt-3">
                <h5>Contact Groups</h5>
                <div class="form-row">
                    <div class="col-sm-12 form-group">
                        <label for="contact_groups">Select a Contact Group</label>
                        <select name="contact_group_id" class="form-control py-3" id="contact_group">
                            <option value="">Select a group</option>
                            @foreach ($contactGroups as $group)
                                <option value="{{ $group['id'] }}">{{ $group['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback">error</span>

                    </div>

                </div>
            </div>
        </div>


        {{--<div class="card p-3 mt-5">
            <h5>Invitations and Invitation Messages</h5>
            <div class="row">
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-check pt-3">
                                <label class="form-check-label" for="enable_guest_list">
                                    <input class="form-check-input" type="checkbox" name="enable_guest_list" id="enable_guest_list">
                                    <span class="form-check-sign font-weight-bold">Event is Strictly by Invitation</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="guest-list-enabled">
                        <div class="form-row">
                            <div class="col-sm-12 form-group">
                                <label for="">Upload Guest List <span class="text-danger">*</span></label>
                                <div class="file-uploader disabled text-center d-flex align-items-center justify-content-center disabled" data-target="#guest-list-uploader">
                                    Click to select file
                                </div>
                                <input style="z-index: -1" type="file" name="guest_list_file" id="guest-list-uploader" disabled class="custom-file-input form-control" accept=".csv, .xlsx, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                <span class="invalid-feedback">error</span>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route ('guests-list.download-template') }}" disabled type="button" class="btn btn-outline">Download Template</a>
                                    <button href="{{ route ('guests-list.download-template') }}" disabled type="button" class="btn btn-outline preview-guest-list-button" data-toggle="modal" data-target="#guest-list-preview-modal">Preview List</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-check pt-3">
                                <label class="form-check-label" for="assign_table_numbers">
                                    <input class="form-check-input" type="checkbox" name="assign_table_numbers" id="assign_table_numbers">
                                    <span class="form-check-sign font-weight-bold">Assign Table Numbers</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="assign-table-numbers-enabled">
                        <div class="form-row">
                            <div class="col-sm-12 form-group">
                                <label for="guests_per_table">Guests Per Table <span class="text-danger">*</span></label>
                                <input type="number" disabled class="form-control @error('guests_per_table') is-invalid @enderror" name="guests_per_table" id="guests_per_table" placeholder="E.g.: 10">
                                <span class="invalid-feedback">error</span>
                            </div>
                            <div class="col-sm-12">
                                <div class="alert alert-info">
                                    Tables are assigned based on the order in your uploaded file. You may, therefore, arrange the guests, in your file, in the order you want them to be assigned tables
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-check pt-3">
                                <label class="form-check-label" for="enable_invitation_messages">
                                    <input class="form-check-input" type="checkbox" name="enable_invitation_messages" id="enable_invitation_messages">
                                    <span class="form-check-sign font-weight-bold">Send Invitation Messages to Contact Group</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="invitation-messages-enabled">
                        <div class="form-row">
                            <div class="col-sm-12 form-group">
                                <label for="invitation_message">Invitation SMS Message <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('invitation_message') is-invalid @enderror" name="invitation_message" id="invitation_message" placeholder="Enter Greeting Message" disabled>{{ old('invitation_message') }}</textarea>
                                <span class="invalid-feedback">error</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}


        <div class="card p-3 mt-5">
            <div class="mt-3">
                <h5>Ticketing</h5>


                <div class="form-row align-items-center ticketing-type-wrapper">
                    <div class="col-sm-4">
                        <div class="form-check pt-3">
                            <label class="form-check-label" for="enable_ticketing">
                                <input class="form-check-input" type="checkbox" name="ticketing" id="enable_ticketing">
                                <span class="form-check-sign font-weight-bold">
                                    Paid Event</span>
                            </label>
                        </div>

                    </div>


                    <div class="form-row col-12 pt-3 ticketing-enabled">

                        <div class="col-md-5 form-group">
                            <label for="ticketing_start_time">Enable sale of tickets from</label>
                            <input type="text" onfocus="this.type='datetime-local'"
                                class="form-control @error('ticketing_start_time') is-invalid @enderror py-3"
                                name="ticketing_start_time" id="ticketing_start_time" disabled>
                            <span class="invalid-feedback">error</span>
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="ticketing_end_time">End ticket sales at</label>
                            <input type="text" onfocus="this.type='datetime-local'"
                                class="form-control @error('ticketing_end_time') is-invalid @enderror py-3"
                                name="ticketing_end_time" id="ticketing_end_time" disabled>
                            <span class="invalid-feedback">error</span>

                        </div>

                        <div class="col-sm-2 text-center align-self-end">
                            <button class="btn btn-danger my-3" id="add-ticket-type-btn" type="button" disabled>Add
                                Type</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="card p-3 mt-5">
            <div class="mt-3">
                <h5>Pre-Registration</h5>
                <div class="form-row align-items-center">
                    <div class="col-sm-4">
                        <div class="form-check pt-3">
                            <label class="form-check-label" for="enable_preregistration">
                                <input class="form-check-input" type="checkbox" name="enable_pre_registration"
                                    id="enable_preregistration">
                                <span class="form-check-sign font-weight-bold">
                                    Attendees can pre-register</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="row preregistration-enabled d-none">
                            <div class="col-sm-6 form-group">
                                <label for="pre_registration_start_time">Start Time</label>
                                <input type="text" onfocus="this.type='datetime-local'" class="form-control py-3"
                                    name="pre_registration_start_time" id="pre_registration_start_time">
                                <span class="invalid-feedback">error</span>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="pre_registration_end_time">End Time</label>
                                <input type="text" onfocus="this.type='datetime-local'" class="form-control py-3"
                                    name="pre_registration_end_time" id="pre_registration_end_time">
                                <span class="invalid-feedback">error</span>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-row">
                    <div class="form-check pt-3 preregistration-enabled d-none">
                        <label class="form-check-label" for="enable_preregistration_questions">
                            <input class="form-check-input" type="checkbox" name="enable_pre_registration_questions"
                                id="enable_preregistration_questions">
                            <span class="form-check-sign font-weight-bold">
                                Ask attendees different set of questions during pre-registration ?</span>
                        </label>
                    </div>
                </div>
                <div class="mt-2 preregistration-container d-none">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="text-sm">Questions for Pre-Registration</h5>

                        <a href="#"
                            class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions"
                            id="add-preregistration-question-btn">Add Question
                        </a>
                    </div>
                    <div class="pre-registration-questions-wrapper px-5">

                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div class="d-flex justify-content-between">
                    <h5>Event's Questions</h5>

                    <a href="#"
                        class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions"
                        id="add-question-btn">Add Questions
                    </a>
                </div>
                {{-- <div class="questions-wrapper px-3 ">
                    <div class="form-row border p-2" id="questions-0">
                        <div class="col-sm-3 form-group">
                            <label for="title-0">Title</label>
                            <input class="form-control py-3" name="questions[0][title]" id="title-0"
                                placeholder="Enter question title" value="Name" readonly />
                            <span class="invalid-feedback">error</span>
                        </div>

                        <div class="col-sm-4 form-group">
                            <label for="question-0">Question</label>
                            <input name="questions[0][question]" id="question-0" class="form-control py-3"
                                placeholder="Enter question" value="What is your name?" />
                            <span class="invalid-feedback">error</span>
                        </div>
                        <div class="col-sm-2 form-group">
                            <label for="type">Select Question Type</label>
                            <select name="type" class="form-control py-3" id="type"
                                onchange="showOptions(this.value,'options-text-0')">
                                <option value="text">Text</option>
                                <option value="options">Options</option>
                            </select>
                            <span class="invalid-feedback">error</span>
                        </div>
                        <div class="col-sm-1 form-group question-order">
                            <label for="order">Order</label>
                            <input type="number" class="form-control py-3" name="questions[0][order]" value="1">
                            <span class="invalid-feedback">error</span>
                        </div>

                        <div class="col-sm-1 text-center align-self-end">
                            <button class="btn btn-danger my-3" id="enable-name-question" type="button"
                                data-item-enabled="true">Disable</button>
                        </div>

                        <div class="row p-2 d-none" id="options-text-0">

                            <div class="col-sm-6 form-group pt-3">
                                <label for="question-0">Enter Options Text</label>
                                <input name="questions[0][question]" id="question-0" class="form-control py-3"
                                    placeholder="Enter question" />
                                <span class="invalid-feedback">error</span>
                            </div>
                            <div class="col-sm-6 form-group pt-3">
                                <label for="question-0">Enter Options Text</label>
                                <input name="questions[0][question]" id="question-0" class="form-control py-3"
                                    placeholder="Enter question" />
                                <span class="invalid-feedback">error</span>
                            </div>
                            <div class="col-sm-6 form-group pt-3">
                                <label for="question-0">Enter Options Text</label>
                                <input name="questions[0][question]" id="question-0" class="form-control py-3"
                                    placeholder="Enter question" />
                                <span class="invalid-feedback">error</span>
                            </div>
                            <div class="col-sm-6 form-group pt-3">
                                <label for="question-0">Enter Options Text</label>
                                <input name="questions[0][question]" id="question-0" class="form-control py-3"
                                    placeholder="Enter question" />
                                <span class="invalid-feedback">error</span>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="questions-wrapper px-5">
                    <div class="form-row" id="questions-0">
                        <div class="col-sm-5 form-group">
                            <label for="title-0">Title</label>
                            <input class="form-control py-3" name="questions[0][title]" id="title-0"
                                placeholder="Enter question title" value="Name" readonly />
                            <span class="invalid-feedback">error</span>
                        </div>

                        <div class="col-sm-5 form-group">
                            <label for="question-0">Question</label>
                            <input name="questions[0][question]" id="question-0" class="form-control py-3"
                                placeholder="Enter question" value="What is your name?" />
                            <span class="invalid-feedback">error</span>
                        </div>

                        <div class="col-sm-1 form-group question-order">
                            <label for="order">Order</label>
                            <input type="number" class="form-control py-3" name="questions[0][order]" value="1">
                            <span class="invalid-feedback">error</span>
                        </div>

                        <div class="col-sm-1 text-center align-self-end">
                            <button class="btn btn-danger my-3" id="enable-name-question" type="button"
                                data-item-enabled="true">Disable</button>
                        </div>

                    </div>
                </div>

                <div class="text-right button-wrapper">
                    <button class="btn btn-primary" id="save-btn">
                        <span class="spinner-border spinner-border-sm d-none loader" role="status"
                            aria-hidden="true"></span>
                        <span>Save</span>
                    </button>
                </div>
            </div>
        </div>
    </form>


    <div class="modal fade" id="guest-list-preview-modal" tabindex="-1" role="dialog" aria-labelledby="guestListPreview" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Guest List Preview</h5>
                </div>
                <div class="modal-body">
                    <div class="guest-list-preview-container">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover table-striped table-bordered dataTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ mix('js/events.js') }}"></script>
    <script src="{{ mix('js/select-teller.js') }}"></script>


    <script>
        //toggle options
        const showOptions = (type, id) => {
            if (type === "options") {
                document.querySelector(`#${id}`).classList.remove("d-none")
            } else {
                document.querySelector(`#${id}`).classList.add("d-none")
            };
        }

        $.ajax({
            url: 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyA7l_sDgjnI7CfVFPLYyP50pYQ0j3Mm9Ck',
            dataType: 'json',
            type: 'GET',
            success: function(response){
                let options = '';
                if(response.items !== ''){
                    $.each(response.items, function(i, v){
                        options += '<option value="'+v.files.regular+'">'+v.family+'</option>';
                    });
                    $('.font-select').html(options);
                }
            },
            error: function(){

            }
        })
    </script>
@endpush
