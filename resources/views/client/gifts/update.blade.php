@extends('layout.client')
@section('script')
@endsection
@section('content')
    @include('partials.toast')
    <section>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h6>Update Gift [{{ $gift->code }}] for "{{ $event->name }}"</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <form action="{{ route ('gifts.update', $gift) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="type">Gift Type <span class="text-danger">*</span></label>
                                        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                            <option value="wrapped parcel"{{ old ('type') == 'wrapped parcel' || $gift->type === 'wrapped parcel' ? 'selected' : '' }}>Wrapped Parcel</option>
                                            <option value="unwrapped parcel"{{ old ('type') == 'unwrapped parcel' || $gift->type === 'unwrapped parcel' ? 'selected' : '' }}>Unwrapped Parcel</option>
                                        </select>
                                        <span class="invalid-feedback">Type is required must be either Wrapped Parcel or Unwrapped Parcel</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="form-label">Item Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ !empty(old ('name')) ? old ('name') : $gift->name }}" id="name" name="name" placeholder="E.g.: A box of Bic Pen">
                                        <span class="invalid-feedback">Item Name is required if Unwrapped Parcel type is selected</span>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="attendee_id" class="form-label">Donor <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('attendee_id') is-invalid @enderror" id="attendee_id" name="attendee_id">
                                                @if(!empty($event->attendees))
                                                    @foreach($event->attendees as $attendee)
                                                        <option {{ old ('attendee_id') == $attendee->id || $gift->attendee_id == $attendee->id ? 'selected' : '' }} value="{{ $attendee->id }}">{{ !empty($attendee->getName ()) ? $attendee->getName () . ' ('.$attendee->phone.')' : $attendee->phone }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">- Select Donor -</option>
                                                @endif
                                            </select>
                                            <span class="invalid-feedback">Kindly select a Donor</span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" value="{{ !empty(old ('quantity')) ? old ('quantity') : $gift->quantity }}" id="quantity" name="quantity" placeholder="E.g.: 2" min="1">
                                            <span class="invalid-feedback">Quantity is required and cannot be less than 1</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Enter description (optional)">{{ !empty(old ('description')) ? old ('description') : $gift->description }}</textarea>
                                        <span class="invalid-feedback">error</span>
                                    </div>
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <div class="form-group float-right">
                                        <button type="submit" class="btn btn-primary">Update Gift</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
