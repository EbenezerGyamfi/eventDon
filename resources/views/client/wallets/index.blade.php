@extends('layout.client')

@section('content')
    @include('partials.toast')

    <div>
        {{-- //Summary cards --}}
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-5 col-md-4 card-resize">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-credit-card text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8 card-resize">
                                <div class="numbers">
                                    <p class="card-category"> Balance</p>
                                    <p class="card-title"><small>&#8373;</small>
                                        {{ round($userWallet->balance, 2) ?? '0' }}</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-5 col-md-4 card-resize">
                                <div class="icon-big text-center icon-primary">
                                    <i class="nc-icon nc-money-coins text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8 card-resize">
                                <div class="numbers">
                                    <p class="card-category"> Transactions</p>
                                    <p class="card-title"><small>&#8373;</small>
                                        0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-5 col-md-4 card-resize">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-credit-card-2-front icon-big text-success text-center p-0 m-0"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z" />
                                    <path
                                        d="M2 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                                </svg>
                            </div>
                            <div class="col-7 col-md-8 card-resize">
                                <div class="numbers">
                                    <p class="card-category"> Credits</p>
                                    <p class="card-title"><small>&#8373;</small> 0</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body py-4">
                        <div class="row">
                            <div class="col-5 col-md-4 card-resize">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                    class="bi bi-cash-stack icon-big text-danger text-center p-0 m-0" viewBox="0 0 16 16">
                                    <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z" />
                                    <path
                                        d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z" />
                                </svg>
                            </div>
                            <div class="col-7 col-md-8 card-resize">
                                <div class="numbers">
                                    <p class="card-category"> Debits</p>
                                    <p class="card-title"><small>&#8373;</small>
                                        {{ $statistics['first_for_users_events'] ?? '0' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- //Wallets Table --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex flex-row justify-content-between align-items-center">
                        <h4 class="card-title"> Wallets Events</h4>

                        <button
                            class="btn btn-outline-primary d-flex flex-row justify-content-center align-items-center account-actions"
                            data-toggle="modal" data-target="#paymentModal">
                            Deposit
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-cash-coin mt-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                                <path
                                    d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                                <path
                                    d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                            </svg>

                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive overflow-auto">

                            {{ $dataTable->table(['class' => 'table w-100']) }}

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>






    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('payment.store') }}">
                        @csrf
                        <input type="hidden" name="itemId" value="{{ $userWallet->id }}">
                        <input type="hidden" name="currency" value="{{ $userWallet->currency }}">
                        <div class="form-group">
                            <label for="channel">Payment Method</label>
                            <select class="form-control" id="channel" name="channel">
                                <option value="mobile_money" {{ old('channel') == 'mobile_money' ? 'selected' : '' }}>
                                    Mobile Money</option>
                                <option value="card" {{ old('channel') == 'card' ? 'selected' : '' }}>Card</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" placeholder="Enter Amount"
                                name="amount" value="{{ old('amount') }}">
                        </div>

                        <div class="form-group momo-details">
                            <label for="account_number">Phone Number</label>
                            <input type="number" class="form-control" id="account_number"
                                placeholder="Enter phone number" name="account_number"
                                value="{{ old('account_number') }}">
                        </div>

                        <div class="form-group momo-details">
                            <label for="provider">Payment Method</label>
                            <select class="form-control" id="provider" name="provider">
                                <option value="mtn">MTN</option>
                                <option value="vodafone">Vodafone</option>
                                <option value="airteltigo">AirtelTigo</option>
                            </select>
                        </div>

                        <div class="mx-auto text-center">
                            <button type="submit" class="btn btn-primary col-10 mx-auto">Deposit</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}

    @if ($errors->any())
        <script>
            $('#paymentModal').modal('show')
        </script>
    @endif

    <script>
        var paymentprovider = $('#channel');
        paymentprovider.on('change', function(event) {
            var paymentChannel = event.target.value;

            if (paymentChannel != 'mobile_money') {
                $('.momo-details').addClass('d-none');
            } else {
                console.log('here');
                $('.momo-details').removeClass('d-none');
            }
        });
    </script>
@endpush
