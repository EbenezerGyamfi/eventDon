@extends('layout.client')

@section('content')
<div class="pt-5">
    <div class="card col-12 mx-auto ">
        <div class="card-header ">
            <h4 class="card-title">Create a contact group</h4>
        </div>
        <div class="card-body ">
            <form action="{{ route('contacts.groups.store') }}" method="POST" class="row">
                @csrf
                <div class="form-group has-label col-12">
                    <label>
                        Name *
                    </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror py-3" name="name"
                        id="name" placeholder="Enter name of contact group" value="{{ old('name') }}">
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group has-label col-12">
                    <label for="description">
                        Description *
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                        id="description" placeholder="Enter description of group"
                        rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="category form-category mx-4">* Required fields</div>

            </form>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary" id="create-btn">Add Group</button>
        </div>
    </div>

</div>
</div>
@endsection

@push('scripts')
<script>
    $('#create-btn').on('click', function() {
            $('form').submit();
        });
</script>
@endpush
