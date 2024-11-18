@extends('layout.client')

@section('content')
    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card p-3">
            <h5>Event Details</h5>
            <div class="form-row">
                <div class="col-sm-6 form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror py-3" name="name"
                        id="name" value="{{ $event->name }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-6 form-group">
                    <label for="venue">Venue</label>
                    <input type="text" class="form-control @error('venue') is-invalid @enderror py-3" name="venue"
                        id="venue" value="{{ $event->venue }}">
                    @error('venue')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-row mt-3">

                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label for="start_time">Start Time</label>
                            <input type="text" onfocus="this.type='datetime-local'"
                                class="form-control @error('start_time') is-invalid @enderror py-3" name="start_time"
                                id="start_time" value="{{ $event->start_time }}">
                            @error('start_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="end_time">End Time</label>
                            <input type="text" onfocus="this.type='datetime-local'"
                                class="form-control @error('end_time') is-invalid @enderror py-3" name="end_time"
                                id="end_time" value="{{ $event->end_time }}">
                            @error('end_time')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="expected_attendees">Expected Number of Attendees</label>
                    <input type="number" class="form-control @error('expected_attendees') is-invalid @enderror py-3"
                        name="expected_attendees" id="expected_attendees" value="{{ $event->expected_attendees }}">
                    @error('expected_attendees')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row mt-3">
                <div class="col-sm-6">
                    <label for="program_lineup">Upload Program Lineup</label>
                    <div>
                        <label for="program_lineup" class="file-label d-block btn btn-outline-primary mt-0">Click to upload
                            program line up</label>
                        <input type="file" class="d-none @error('program_lineup') is-invalid @enderror"
                            name="program_lineup" id="program_lineup">
                        @error('program_lineup')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="form-row" id="tellers">
                <div class="col-sm-6 form-group">
                    <label for="assigned_users">Assign Tellers To Event</label>
                    <select style="width: 100%" id="assigned_users" class="form-control py-3" multiple>
                        @foreach ($event->tellers as $teller)
                            <option value="{{ $teller->id }}" selected>{{ $teller->name }}</option>
                        @endforeach
                    </select>
                    <span class="invalid-feedback">error</span>
                </div>
            </div>
        </div>

        @if ($event->ticketing !== 0 && $event->status !== 'completed')
            <div class="card p-3 mt-5">
                <div class="mt-3">
                    <h5>Ticketing</h5>


                    <div class="form-row align-items-center">
                        <div class="col-sm-4">
                            <div class="form-check pt-3">
                                <label class="form-check-label" for="enable_ticketing">
                                    <input class="form-check-input" type="checkbox" id="enable_ticketing">
                                    <span class="form-check-sign font-weight-bold">
                                        Edit ticketing</span>
                                </label>
                            </div>

                        </div>

                        <div class="form-row col-12 pt-3 ticketing-enabled">
                            <div class="col-sm-6 form-group">
                                <label for="name">Ticket Price</label>
                                <input type="number" class="form-control @error('name') is-invalid @enderror py-3"
                                    name="ticket_price" id="ticket_price" placeholder="Ticket Price"
                                    value="{{ old('ticket_price') ?? $event->ticket_price }}" disabled>
                                <span class="invalid-feedback">error</span>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label for="venue">No of Tickets</label>
                                <input type="number" class="form-control @error('venue') is-invalid @enderror py-3"
                                    name="no_of_available_tickets" id="ticket_no" placeholder="No of tickets to be sold"
                                    value="{{ old('no_of_available_tickets') ?? $event->no_of_available_tickets }}"
                                    disabled>
                                <span class="invalid-feedback">error</span>

                            </div>
                        </div>
                        <div class="form-row col-12 pt-3 ticketing-enabled">
                            <div class="col-sm-6 form-group">
                                <label for="ticketing_start_time">Enable sale of tickets from</label>
                                <input type="text" placeholder="{{ $event->ticketing_start_time }}"
                                    onfocus="this.type='datetime-local'"
                                    class="form-control @error('ticketing_start_time') is-invalid @enderror py-3"
                                    name="ticketing_start_time" id="ticketing_start_time"
                                    value="{{ $event->ticketing_start_time }}" disabled>
                                <span class="invalid-feedback">error</span>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="ticketing_end_time">End ticket sales at</label>
                                <input type="text" placeholder="{{ $event->ticketing_end_time }}"
                                    onfocus="this.type='datetime-local'"
                                    class="form-control @error('ticketing_end_time') is-invalid @enderror py-3"
                                    name="ticketing_end_time" id="ticketing_end_time"
                                    value="{{ $event->ticketing_end_time }}" disabled>
                                <span class="invalid-feedback">error</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif



        <div class="card p-3 mt-5">
            <h5>Greeting Messages</h5>
            <div class="form-row">
                <div class="col-sm-6 form-group">
                    <label for="greeting_message">Greeting Message</label>
                    <textarea class="form-control @error('greeting_message') is-invalid @enderror" name="greeting_message"
                        id="greeting_message" placeholder="Enter Greeting Message">{{ $event->greeting_message }}</textarea>
                    @error('greeting_message')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-sm-6 form-group">
                    <label for="venue">Goodbye Message</label>
                    <textarea name="goodbye_message" id="goodbye_message"
                        class="form-control @error('greeting_message') is-invalid @enderror" placeholder="Enter Goodbye Message">{{ $event->goodbye_message }}</textarea>
                    @error('goodbye_message')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="text-right button-wrapper">
                <button type="submit" class="btn btn-primary" id="save-btn">
                    <span class="spinner-border spinner-border-sm d-none loader" role="status"
                        aria-hidden="true"></span>
                    <span>Save</span>
                </button>
            </div>

        </div>


    </form>
@endsection

@push('scripts')
    <script src="{{ mix('js/events.js') }}"></script>
    <script src="{{ mix('js/select-teller.js') }}"></script>
@endpush
