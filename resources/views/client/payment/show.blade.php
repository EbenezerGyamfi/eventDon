@extends('layout.client')

@section('content')
    <section style="height: 100vh" class="d-flex bg-white flex-column justify-content-center">
        <div class="loading text-center">
            <div class="d-flex justify-content-center loader">
                <div class="spinner-border text-warning" style="width: 6rem; height: 6rem" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <h3>Please check your phone to confirm the payment</h3>
        </div>

        <div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        var transaction = @json($transaction);
        var checkStatus = function(handler) {
            $.get(
                route('payment.status', transaction.id),
                function(response) {
                    if (response.status === 'FAILED') {
                        $('.loading').addClass('d-none');
                        Swal.fire({
                            title: 'Payment was unsuccessfull',
                            icon: 'error',
                            confirmButtonText: 'Okay',
                            showLoaderOnConfirm: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = route('wallet-events.index');
                            }
                        })

                        setTimeout(function() {
                            window.location.href = route('wallet-events.index');
                        }, 1000);
                    } else if (response.status === 'SUCCESS') {
                        $('.loading').addClass('d-none');
                        Swal.fire({
                            title: 'Payment was successfull',
                            icon: 'success',
                            confirmButtonText: 'Okay',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = route('wallet-events.index');
                            }
                        })

                        setTimeout(function() {
                            window.location.href = route('wallet-events.index');
                        }, 1000);
                    } else {
                        setTimeout(function() {
                            checkStatus()
                        }, 1200);
                    }
                }
            );
        }

        checkStatus();
    </script>
@endpush
