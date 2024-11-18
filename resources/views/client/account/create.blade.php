@extends('layout.client')

@section('content')
    <div class="pt-5">
        <div class="card col-12 mx-auto ">
            <div class="card-header ">
                <h4 class="card-title">Create a payment account</h4>
            </div>
            <div class="card-body ">
                <form action="{{route('accounts.store')}}" method="POST" class="row ">
                    @csrf
                    <div class="form-group has-label col-12">
                        <label for="name">
                            Account Name *
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror py-3" name="name"
                            id="name" placeholder="Enter account name" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group has-label col-12">
                        <label for="type">
                            Account Type *
                        </label>
                        <select class="form-control @error('type') is-invalid @enderror " aria-label="Default select example" name="type" id="type" value="{{old('type')}}">
                            <option value="">Select Account Type</option>
                            <option value="mobile" {{old('type') == 'mobile' ? 'selected' : ''}}>Mobile Money</option>
                            {{-- <option value="2">Card</option> --}}
                            <option value="wallet" {{old('type') == 'wallet' ? 'selected' : ''}}>Wallet</option>
                        </select>
                        @error('type')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group has-label col-12 mobile-details {{old('type') != 'mobile' ? 'd-none' : ''}}">
                        <label for="network">
                            Network *
                        </label>
                        <select class="form-control @error('network') is-invalid @enderror" aria-label="select network" name="network" id="network" value="{{old('network')}}">
                            <option selected>Select Network</option>
                            <option value="vodafone" {{old('network') == 'vodafone' ? 'selected' : ''}}>Vodafone</option>
                            <option value="mtn" {{old('network') == 'mtn' ? 'selected' : ''}} >MTN</option>
                            <option value="airteltigo" {{old('network') == 'airteltigo' ? 'selected' : ''}}>AirtelTigo</option>
                        </select>
                        @error('network')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group has-label col-12 mobile-details {{old('type') != 'mobile' ? 'd-none' : ''}}">
                        <label for="account_number">
                            Account Number *
                        </label>
                        <input class="form-control @error('account_number') is-invalid @enderror" name="account_number" id="account_number" type="text" value="{{old('account_number')}}">
                        @error('account_number')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="category form-category mx-4">* Required fields</div>

                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary" id="create-btn">Add Account</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var accountTypeInput = $('#type');
        accountTypeInput.on('change', function(event) {
            if(event.target.value == 'mobile') {
                $('.mobile-details').removeClass('d-none');
            } else {
                $('.mobile-details').addClass('d-none');   
            }
        });

        $('#create-btn').on('click', function() {
            $('form').submit();
        });
    </script>
@endpush
