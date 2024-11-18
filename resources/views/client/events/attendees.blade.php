@extends('layout.client')

@section('content')
    <div class="events-details">
        @include('partials.events.tabs')
        @include('partials.toast')

        <div class="event-questions">

            <div class="card mt-5">
                <div class="card-header">
                    <div class="card-header d-flex flex-row justify-content-between">
                        <h4 class="card-title"> All Attendees </h4>




                        @if (auth()->user()->role == 'client')
                            <div class="d-flex justify-content-center align-items-center account-actions">

                                <a href="{{ route('events.attendees.export', $event->id) }}"
                                    class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions"
                                    target="_blank">
                                    Export Attendees
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-cloud-download-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.5a.5.5 0 0 1 1 0V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.354 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V11h-1v3.293l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z" />
                                    </svg>
                                </a>






                                <div class="dropdown">
                                    <button
                                        class="btn btn-primary dropdown-toggle d-flex flex-row justify-content-center align-items-center account-actions"
                                        type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                        Contact Attendees</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <span
                                            class="dropdown-item d-flex flex-row justify-content-center align-items-center account-actions pointer"
                                            data-toggle="modal" data-target="#sendSMSModal">
                                            Send SMS
                                            <svg xmlns=" http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                                            </svg>
                                        </span>
                                        {{-- <span
                                            class="dropdown-item d-flex flex-row justify-content-center align-items-center account-actions pointer"
                                            data-toggle="modal" data-target="#sendVoiceModal">

                                            Send Voice
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                fill="currentColor" class="bi bi-voicemail" viewBox="0 0 16 16">
                                                <path
                                                    d="M7 8.5A3.49 3.49 0 0 1 5.95 11h4.1a3.5 3.5 0 1 1 2.45 1h-9A3.5 3.5 0 1 1 7 8.5zm-6 0a2.5 2.5 0 1 0 5 0 2.5 2.5 0 0 0-5 0zm14 0a2.5 2.5 0 1 0-5 0 2.5 2.5 0 0 0 5 0z" />
                                            </svg>

                                        </span> --}}
                                    </div>
                                </div>

                            </div>
                        @endif


                    </div>
                    @if ($numberOfPresentAttendees > $attendeesLimit)
                        <div class="alert alert-info my-2" role="alert">
                            The total number of attendees exceeds the limit of your plan. Please
                            contact support to upgrade your plan
                        </div>
                    @endif
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


@push('modals')
    {{-- sending sms modal --}}

    <div class="modal fade" id="sendSMSModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Send SMS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('events.attendees.send-sms', $event->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="sender">Enter Sender Name</label>
                            <input type="text" name="sender" class="form-control py-3" id="sender" required>
                            @error('sender')
                                @php
                                    toast($message, 'error');
                                @endphp
                            @enderror
                        </div>
                        <div>
                            <label for="message">Enter Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                            @error('message')
                                @php
                                    toast($message, 'error');
                                @endphp
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary float-right">Send</button>
                    </form>
                </div>

            </div>
        </div>
    </div>


    {{-- sending voice sms --}}
    {{-- <div class="modal fade" id="sendVoiceModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Send Voice Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('events.attendees.send-voice-message', $event->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="input-group col-6*">
                            <div class="custom-file">
                                <input type="file" name="message" class="custom-file-input my-5 form-control"
                                    id="inputGroupFile02" required>

                                <label class="custom-file-label" for="inputGroupFile02"
                                    aria-describedby="inputGroupFileAddon02">Choose file</label>
                            </div>
                            @error('message')
                                @php
                                    toast($message, 'error');
                                @endphp
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary float-right">Upload</button>

                    </form>
                </div>

            </div>
        </div>
    </div> --}}
@endpush

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="{{ mix('js/events.js') }}"></script>
@endpush
