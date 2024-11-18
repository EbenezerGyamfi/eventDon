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