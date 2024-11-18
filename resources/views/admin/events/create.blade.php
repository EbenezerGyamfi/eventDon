@extends('layout.admin')
@section('content')
<form method="post" action="{{route('admin.events.store')}}">
    @csrf
    @if($errors->any())
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
    @endif
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Event details</h5>
            <div class="row my-4">
                <div class="col-md-6 mb-4">
                    <div class="form-floating">
                        <input id="name" name="name" class="form-control" type="text" placeholder="Event name"
                            required="" autocomplete="on">
                        <label for="name">Name:</label>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating">
                        <input id="venue" name="venue" class="form-control" type="text" placeholder="Event venue"
                            required="" autocomplete="on"><label for="venue">Venue:</label>
                        <!---->
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="form-floating">
                        <input id="start_time" name="start_time" class="form-control" type="datetime-local"
                            placeholder="Start time of event" required="" autocomplete="on"><label
                            for="start_time">Start
                            time:</label>
                        <!---->
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="form-floating">
                        <input id="end_time" name="end_time" class="form-control" type="datetime-local"
                            placeholder="End time of event" required="" autocomplete="on"><label for="end_time">End
                            time:</label>
                        <!---->
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-floating input-group" placehoder="USSD code of event"><span
                            class="input-group-text">*928*</span>
                        <div class="form-floating"><input id="code" placehoder="USSD code of event" class="form-control"
                                name="code" type="text" placeholder="Enter your code here!" list="codes">
                            <label for="code">USSD code:</label>
                        </div><span class="input-group-text">#</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" name="expected_attendees" id="expected-attendees" type="text"
                            placeholder="Expected number of Attendees" required="" autocomplete="on">
                        <label for="expected-attendees">Expected number of Attendees:</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Greeting and Goodbye messages</h5>
            <div class="row my-5">
                <div class="col-md-6">
                    <div class="form-floating">
                        <textarea class="form-control" name="greeting_message" placeholder="Enter your message here!"
                            id="greeting-message" style="height: 160px;"></textarea>
                        <label for="greeting-message"> Greeting message</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <textarea id="goodbye-message" name="goodbye_message" class="form-control"
                            placeholder="Enter your message here!" style="height: 160px;"></textarea>
                        <label for="goodbye-message">Questions Goodbye message</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Event questions</h5>
        </div>
        <div class="card-content">
            <div class="row m-4">
                <div class="form-check" id="linkToForm">
                    <label class="form-check-label" for="hasContactGroup">
                        <input class="form-check-input" id="hasContactGroup" type="checkbox" value="true">
                        Link to contact group?
                        <span class="form-check-sign">
                            <span class="check"></span>
                        </span>
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="form-floating" id="contactGroup" style="display: none">
                        <select id="type" class="form-control" placeholder="Enter your value here!" required=""
                            autocomplete="on">
                            <option value="21"></option>
                        </select><label for="type">Contact groups:</label>
                    </div>
                </div>
            </div>
            <div class="row m-4">
                <div class="col-md-3 ">
                    <div class="form-floating">
                        <input id="q-title" name="title" class="form-control" type="text"
                            placeholder="Question title here!" required="" autocomplete="on">
                        <label for="q-title">Question title:</label>
                        <!---->
                    </div>
                </div>
                <div class="col-md-7 mb-3">
                    <div class="form-floating">
                        <input id="question" name="questions" class="form-control" type="text"
                            placeholder="Question here!" required="" autocomplete="on">
                        <label for="question">Question:</label>
                        <!---->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="w-100 d-flex mb-4">
        <input type="hidden" name="organizer_name" value="{{auth()->user()->name}}">
        <input type="hidden" name="organizer_email" value="{{auth()->user()->email}}">
        <input type="hidden" name="organizer_phone" value="{{auth()->user()->phone}}">
        <button type="submit" class="btn btn-primary ms-auto px-5">
            Save
        </button>
    </div>
</form>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#hasContactGroup').click(function() {
            if ($(this).val() == ('true') && $(this).is(':checked')) {
                $('#contactGroup').show();
            } else {
                $('#contactGroup').hide();
            }
        });
    });
</script>
@endsection
