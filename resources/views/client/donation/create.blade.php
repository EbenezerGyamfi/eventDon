@extends('layout.client')

@section('content')
    <div class="pt-5">

        @include('partials.toast')
        <div class="card col-12 mx-auto py-2">
            <div class="card-header d-flex flex-row justify-content-between">
                <h4 class="card-title">
                    Recieve Donations
                </h4>

                <a href="{{route('events.donations.index', $event->id)}}"
                    class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions">
                    <i class="nc-icon nc-minimal-left"></i>
                    Back
                </a>

            </div>
            <div class="card-body ">
                <form action="{{ route('events.donations.store', $event->id) }}" method="POST"
                    class="row col-10 mx-auto py-3">
                    @csrf
                    <input type="hidden" name="attendee_id" id="attendee_id">
                    @error('attendee_id')
                        @php
                            toast($message)
                        @endphp
                    @enderror

                    <div class="form-group has-label col-12">
                        <label>
                            Enter Donator Name or Phone Number *
                        </label>
                        <select class="form-control" id="attendee-select"></select>


                        <div class="form-check pt-3">
                            <label class="form-check-label" for="no-phone">
                                <input class="form-check-input" type="checkbox" name="no_phone" value="0" id="no-phone">
                                <span class="form-check-sign font-weight-bold">
                                    Attendee has no phone number</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group has-label col-6">
                        <label for="name">
                            Name *
                        </label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                            required="true" name="name" id="name" readonly>
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group has-label col-6">
                        <label for="amount">
                            Amount *
                        </label>
                        <input class="form-control @error('amount') is-invalid @enderror" name="amount" type="text"
                            required="true" id="amount" value="{{old('amount')}}">
                        @error('amount')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="category form-category mx-4">* Required fields</div>

            </div>
            <div class="card-footer text-right pb-2">

                <button type="submit" class="btn btn-primary">Save Donation</button>
            </div>
            </form>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var url = "{{ route('events.attendees.search', $event->id) }}";
        $('#attendee-select').select2({
            // tags: true,
            // createTag: function(params) {
            //     // https://stackoverflow.com/questions/14577014/select2-dropdown-but-allow-new-values-by-user/30021059#30021059
            //     return {
            //         id: params.term,
            //         text: params.term,
            //         newOption: true
            //     }
            // },
            ajax: {
                url: url,
                dataType: 'json',
                processResults: function(data) {
                    var results = data.data.map(function(result) {
                        var name = '';
                        if (result.answers.length) {
                            name = result.answers[0].answer
                        }

                        return {
                            id: result.id,
                            text: name + ' (' + result.phone + ')',
                            name: name
                        }
                    });
                    return {
                        results: results
                    }
                }
            }
        });

        $('#attendee-select').on('select2:select', function(event) {
            if (event.params.data.newOption) {
                $('#attendee_id').val('');
            } else {
                $('#attendee_id').val(event.params.data.id)
                $('#name').val(event.params.data.name);
            }
        });

        $('#no-phone').on('change', function(event) {
            var input = event.target;

            if(input.checked) {
                input.value = '1';
                $('#name').removeAttr('readonly').val('');
                $('#attendee-select').val(null).trigger('change');
                $('#attendee_id').val('').attr('disabled', 'disabled');
            } else {
                input.value = '0';
                $('#attendee_id').removeAttr('disabled');
                $('#name').attr('readonly', 'readonly');
            }
        })
    </script>
@endpush
