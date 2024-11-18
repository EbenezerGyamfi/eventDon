@extends('layout.admin')


@section('nav-elements')
    <ul class="navbar-nav" style="margin-left: 30%">
        <li class="nav-item btn-rotate dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user-md" aria-hidden="true"></i>
                <p>
                    <span class="d-lg-none d-md-block">My Section</span>
                </p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" href="#">Profile</a>
                <a class="dropdown-item" href="#">Logout</a>
            </div>
        </li>
    </ul>
@endsection

@section('page_header')
    <div class="row">
        <div class="col-xl-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-money-coins text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Total Amount</p>
                                <p class="card-title">₵ {{number_format($totalAmount,2)}}</p>
                                <p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-5 col-md-4">
                            <div class="icon-big text-center icon-warning">
                                <i class="nc-icon nc-money-coins text-success"></i>
                            </div>
                        </div>
                        <div class="col-7 col-md-8">
                            <div class="numbers">
                                <p class="card-category">Total Amount After Charges</p>
                                <p class="card-title">₵ {{number_format($totalAmountCharges,2)}}</p>
                                <p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
            <h3>{{$eventName}}</h3>
            </div>
            <div class="table-responsive overflow-auto">
                {{ $dataTable->table(['class' => 'table w-100']) }}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{ $dataTable->scripts() }}
@endpush