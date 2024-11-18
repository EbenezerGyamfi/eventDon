@extends('layout.client')

@section('content')
    <div class="pt-5">
        <div class="card user-management col-12 mx-auto py-2">
            <div class="card-header ">
                <h4 class="card-title">
                    <a href="{{route('user-management.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg>
                    </a>
                    <span>Add Teller</span>
                </h4>
            </div>
            <div class="card-body ">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @endif
                <form action="{{ route('user-management.store') }}" method="POST" class="row col-md-10 mx-auto py-3 row">
                    @csrf
                    <input type="hidden" name="parent" value="{{ auth()->user()->id }}">
                    <div class="input-group mb-4 col-12 col-md-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="nc-icon nc-single-02"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Full Name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group mb-4 col-12 col-md-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="color: rgb(102, 97, 91)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#9a999985"
                                    class="bi bi-envelope" viewBox=" 0 0 16 16" style="color: #9a999985">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                                </svg> </span>
                        </div>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                            name="email" value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>




                    <div class="input-group mb-4 col-12 ">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="nc-icon nc-single-02"></i> </span>
                        </div>
                        <select class="form-select form-control" name="role">
                            <option selected>Select Role</option>
                            <option value="client_admin">Admin</option>
                            <option value="teller">Teller</option>
                        </select>

                    </div>



                    <div class="input-group mb-4 col">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#9a999985"
                                    class="bi bi-phone" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
                                    <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg> </span>
                        </div>
                        <input type="tel" placeholder="Phone" name="phone"
                            class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                        @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>


            </div>
            <div class="card-footer text-right pb-2">

                <button type="submit" class="btn btn-primary">Add Teller</button>
            </div>
            </form>

        </div>
    </div>
@endsection
