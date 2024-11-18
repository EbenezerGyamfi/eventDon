@extends('layout.auth')

@section('meta_description', 'Allow EventsDon to make your work easier and make it less tiring to plan events, because
    you deserve a break.')

@section('content')
    <form class="form" action="{{ route('register') }}" method="POST">
        @csrf
        <div class="card card-login">
            <div class="card-header ">
                <a href="{{ route('welcome') }}">
                    <span class="d-flex justify-content-center align-items-center pb-4 pt-2">
                        <svg width="180" height="50" viewBox="0 0 160 30" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M26.8889 0H3.11111C1.39289 0 0 1.39289 0 3.11111V26.8889C0 28.6071 1.39289 30 3.11111 30H26.8889C28.6071 30 30 28.6071 30 26.8889V3.11111C30 1.39289 28.6071 0 26.8889 0Z"
                                fill="#0D3B66" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.66669 7.55554H22.884C23.2549 7.55554 23.5556 7.85623 23.5556 8.22714C23.5556 9.6181 22.428 10.7457 21.0371 10.7457H7.55558C7.06466 10.7457 6.66669 10.3477 6.66669 9.85679V7.55554ZM8.16793 13.3728H19.1309C19.5018 13.3728 19.8025 13.6735 19.8025 14.0444C19.8025 15.4354 18.6749 16.5629 17.284 16.5629H9.05682C8.56589 16.5629 8.16793 16.165 8.16793 15.6741V13.3728ZM22.1334 19.1901H8.16793V21.4913C8.16793 21.9823 8.56589 22.3802 9.05682 22.3802H20.2864C21.6774 22.3802 22.8049 21.2527 22.8049 19.8617C22.8049 19.4908 22.5042 19.1901 22.1334 19.1901Z"
                                fill="#E79D0F" />
                            <path
                                d="M40.6666 19.9111H46.8889V23.3333H37.1111V7.77779H46.7777V11.2H40.6666V13.7778H46.2222V17.1556H40.6666V19.9111ZM52.406 23.3333L47.3393 7.77779H51.2282L54.6726 19.2222L58.1171 7.77779H62.006L56.9393 23.3333H52.406ZM66.6762 19.9111H72.8984V23.3333H63.1206V7.77779H72.7873V11.2H66.6762V13.7778H72.2317V17.1556H66.6762V19.9111ZM83.3489 7.77779H86.9044V23.3333H84.2377L78.2377 14.8889V23.3333H74.6822V7.77779H77.3489L83.3489 16.2222V7.77779ZM99.7917 7.77779V11.2H95.7917V23.3333H92.2362V11.2H88.2362V7.77779H99.7917ZM106.136 23.6445C104.551 23.6445 103.225 23.3038 102.158 22.6222C101.107 21.9259 100.358 20.9852 99.914 19.8L102.981 18.0222C103.603 19.4593 104.692 20.1778 106.247 20.1778C107.655 20.1778 108.358 19.7556 108.358 18.9111C108.358 18.4519 108.129 18.0963 107.67 17.8445C107.225 17.5778 106.381 17.2741 105.136 16.9333C104.484 16.7556 103.914 16.5556 103.425 16.3333C102.936 16.1111 102.455 15.8222 101.981 15.4667C101.522 15.0963 101.166 14.6371 100.914 14.0889C100.677 13.5407 100.558 12.9111 100.558 12.2C100.558 10.763 101.07 9.61483 102.092 8.75556C103.129 7.8963 104.358 7.46667 105.781 7.46667C107.055 7.46667 108.181 7.77039 109.158 8.37779C110.136 8.97039 110.907 9.83705 111.47 10.9778L108.47 12.7333C108.188 12.1407 107.84 11.6963 107.425 11.4C107.01 11.0889 106.462 10.9333 105.781 10.9333C105.247 10.9333 104.833 11.0519 104.536 11.2889C104.255 11.5111 104.114 11.7852 104.114 12.1111C104.114 12.4963 104.292 12.8296 104.647 13.1111C105.018 13.3926 105.773 13.7037 106.914 14.0445C107.536 14.2371 108.018 14.3926 108.358 14.5111C108.699 14.6296 109.129 14.8296 109.647 15.1111C110.181 15.3778 110.581 15.6667 110.847 15.9778C111.129 16.2741 111.373 16.6741 111.581 17.1778C111.803 17.6667 111.914 18.2296 111.914 18.8667C111.914 20.3482 111.381 21.5185 110.314 22.3778C109.247 23.2222 107.855 23.6445 106.136 23.6445Z"
                                fill="#0D3B66" />
                            <path
                                d="M119.691 7.77779C121.839 7.77779 123.632 8.52594 125.069 10.0222C126.521 11.5037 127.246 13.3482 127.246 15.5556C127.246 17.763 126.521 19.6148 125.069 21.1111C123.632 22.5927 121.839 23.3333 119.691 23.3333H113.469V7.77779H119.691ZM119.691 19.9111C120.921 19.9111 121.913 19.5185 122.669 18.7333C123.439 17.9333 123.824 16.8741 123.824 15.5556C123.824 14.2371 123.439 13.1852 122.669 12.4C121.913 11.6 120.921 11.2 119.691 11.2H117.024V19.9111H119.691ZM142.179 21.3111C140.609 22.8667 138.698 23.6445 136.446 23.6445C134.194 23.6445 132.283 22.8667 130.712 21.3111C129.142 19.7556 128.357 17.8371 128.357 15.5556C128.357 13.2741 129.142 11.3556 130.712 9.80001C132.283 8.24445 134.194 7.46667 136.446 7.46667C138.698 7.46667 140.609 8.24445 142.179 9.80001C143.749 11.3556 144.534 13.2741 144.534 15.5556C144.534 17.8371 143.749 19.7556 142.179 21.3111ZM133.201 18.8889C134.075 19.7482 135.157 20.1778 136.446 20.1778C137.734 20.1778 138.809 19.7482 139.668 18.8889C140.542 18.0296 140.979 16.9185 140.979 15.5556C140.979 14.1926 140.542 13.0815 139.668 12.2222C138.809 11.363 137.734 10.9333 136.446 10.9333C135.157 10.9333 134.075 11.363 133.201 12.2222C132.342 13.0815 131.912 14.1926 131.912 15.5556C131.912 16.9185 132.342 18.0296 133.201 18.8889ZM154.981 7.77779H158.536V23.3333H155.87L149.87 14.8889V23.3333H146.314V7.77779H148.981L154.981 16.2222V7.77779Z"
                                fill="#E79D0F" />
                        </svg></span>
                </a>
                <div class="card-header ">
                    <h3 class="header text-center">Register</h3>
                </div>
            </div>
            <div class="card-body ">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="nc-icon nc-single-02"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name"
                        name="name" value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
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
                <div class="input-group">
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


                <div class="row">

                    <div class="input-group col-12 col-sm-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="nc-icon nc-key-25"></i>
                            </span>
                        </div>
                        <input type="password" placeholder="Password" name="password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-group col-12 col-sm-6">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="nc-icon nc-key-25"></i>
                            </span>
                        </div>
                        <input type="password" placeholder="Confirm Password" name="password_confirmation"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <br>
                <div class="g-recaptcha" data-sitekey="{{ config('services.captcha.site_key') }}"></div>
                @error('g-recaptcha-response')
                    <span class="d-block text-danger invalid-feedback">{{ $message }}</span>
                @enderror

            </div>
            <div class="card-footer py-4* text-center">
                <button type="submit" class="btn btn-warning btn-round btn-block mb-3">Register</button>
                <a href="{{ route('login') }}">Already
                    have an Account ?
                    Login</a>
            </div>
        </div>
    </form>
@endsection
