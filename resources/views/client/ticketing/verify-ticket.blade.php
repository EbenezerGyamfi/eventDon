@extends('layout.client')

@section('content')
    @include('partials.toast')
    <div class="pt-5">
        <form class="card col-12 mx-auto py-5" id="verify-qr-code" action="{{ route('ticket.update-status', $event->id) }}"
            method="POST">
            @csrf
            <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <h4 class="card-title">Verify Ticket</h4>



                <button class="btn btn-outline-primary px-5 px-sm-3" data-bs-toggle="modal" type="button"
                    data-bs-target="#staticBackdrop">
                    Scan
                </button>
            </div>

            @if (session('ticketDetails'))
                <div class="w-50 mx-auto">
                    <div class="alert alert-success" role="alert">
                        {{ session('ticketDetails') }}
                    </div>
                </div>
            @endif

            <div class="card-body col-8 mx-auto">
                <input type="text" class="form-control py-3" id="code" placeholder="Enter Ticket Code"
                    name="code" value="{{ old('code') }}">
            </div>
            <div class="card-footer text-center text-sm-right">
                <button type="submit" class="btn btn-primary" id="create-btn">Verify Code</button>

            </div>
        </form>

    </div>




    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Scan QRcode</h5>
                    <button type="button" class="btn-close border-0 bg-none" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div id="reader" width="600px"></div>
                    <div>
                        <p class="h2 scannedcode text-center"></p>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/scanner.js') }}"></script>
@endpush
