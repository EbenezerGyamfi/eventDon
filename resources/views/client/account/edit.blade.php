@extends('layout.client')

@section('content')
    <div class="pt-5">
        <div class="card col-8 mx-auto ">
            <div class="card-header ">
                <h4 class="card-title">Edit payment account</h4>
            </div>
            <div class="card-body ">
                <form action="{{route('accounts.update', $account->id)}}" class="row" method="POST">
                    @csrf
                    @method('put')
                    <input type="hidden" name="type" value="{{$account->type}}">
                    <div class="form-group has-label col-12">
                        <label for="name">
                            Account Name *
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror py-3" name="name"
                            id="name" placeholder="Enter account name" value="{{ old('name') ?? $account->name }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group has-label col-12">
                        <label for="network">
                            Network *
                        </label>
                        <select class="form-control @error('network') is-invalid @enderror" aria-label="select network"
                            name="network" id="network" value="{{ old('network') ?? $account->details ?  $account->details['network'] : ''   }}">
                            <option value="">Select Network</option>
                            <option value="vodafone">Vodafone</option>
                            <option value="mtn">MTN</option>
                            <option value="airteltigo">AirtelTigo</option>
                        </select>
                        @error('network')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group has-label col-12">
                        <label for="account_number">
                            Account Number *
                        </label>
                        <input class="form-control @error('account_number') is-invalid @enderror" name="account_number"
                            id="account_number" type="text" value="{{ old('account_number') ?? $account->account_number }}">
                        @error('account_number')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="category form-category mx-4">* Required fields</div>

                </form>
            </div>
            <div class="card-footer text-right">

                <button type="submit" class="btn btn-primary" id="edit-btn">Save</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#edit-btn').on('click', function() {
            $('form').submit();
        });
    </script>
@endpush