@extends('layout.admin')

@section('content')
    @include('partials.toast')
    @if (session('status') == 'profile-information-updated')
        @php
            toast('Profile Updated successfully', 'success');
        @endphp
    @endif

    @if (session('status') == 'password-updated')
        @php
            toast('Password Updated successfully', 'success');
        @endphp
    @endif
    <div class="col-12 mr-auto ml-auto">
        <!--      Wizard container        -->
        <div class="wizard-container">
            <div class="card card-wizard active" data-color="primary" id="wizardProfile">
                <div class="card-header text-center">
                    <h3 class="card-title">
                        Edit Account
                    </h3>
                    <div class="wizard-navigation" style="background:rgb(154, 154, 154)">
                        <ul class="nav nav-pills justify-content-center align-items-center">
                            <li class="nav-item" style="width: 33.3333%;">
                                <a class="nav-link py-3 active text-white" href="#about" data-toggle="tab" role="tab"
                                    aria-controls="about" aria-selected="true">
                                    <i class="nc-icon nc-single-02"></i>
                                    Profile </a>
                            </li>
                            <li class="nav-item " style="width: 33.3333%;">
                                <a class="nav-link py-3 text-white" href="#account" data-toggle="tab" role="tab"
                                    aria-controls="account" aria-selected="false">
                                    <i class="nc-icon nc-touch-id"></i>
                                    Password </a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        {{-- change user details --}}
                        <div class="tab-pane show active" id="about">
                            <form action="{{ route('admin.profile.update') }}" method="post" novalidate="novalidate"
                                enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="row justify-content-center pt-5">
                                    <div class="col-sm-3">
                                        <div class="pointer" id="profile_picture">
                                            <div class="avatar">
                                                <img src="{{ $user->avatarUrl ?? asset('assets/img/default-avatar.png') }}"
                                                    class="picture-src h-100" id="wizardPicturePreview" title="">
                                                <input type="file" name="avatar" id="wizard-picture">
                                            </div>
                                            <h6 class="description">Choose Picture</h6>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="input-group has-success mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="nc-icon nc-single-02"></i></span>
                                            </div>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror py-3"
                                                name="name" id="name" value="{{ old('name') ?? $user->name }}">
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mt-3">
                                            <div class="input-group has-success">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="nc-icon nc-send"></i></span>
                                                </div>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror py-3"
                                                    name="email" id="email" value="{{ old('email') ?? $user->email }}">
                                                @error('email')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="input-group has-success mt-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="nc-icon nc-circle-10"></i></span>
                                            </div>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror py-3"
                                                name="phone" id="phone" value="{{ old('phone') ?? $user->phone }}">
                                            @error('phone')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="card-footer">

                                    <div class="pull-right">
                                        <input type="submit" class="btn btn-next btn-fill btn-rose btn-wd"
                                            value="Update Profile" aria-invalid="false">

                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                            </form>

                        </div>

                        {{-- Change Password settings --}}

                        <div class="tab-pane" id="account">
                            <form action="{{ route('user-password.update') }}" method="post" novalidate="novalidate">
                                @csrf
                                @method('put')
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 pt-4">
                                        <div class="row">
                                            <div class="col-12 pb-3">
                                                <div class="input-group has-success">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="nc-icon nc-key-25"></i>
                                                        </span>
                                                    </div>
                                                    <input type="password"
                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                        required placeholder="Current Password" name="current_password"
                                                        aria-invalid="false">
                                                    @error('current_password')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="col-12 pb-3">
                                                <div class="input-group has-success">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="nc-icon nc-key-25"></i></span>
                                                    </div>
                                                    <input type="password"
                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                        required placeholder="New Password" name="password"
                                                        aria-invalid="false">
                                                    @error('password')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>

                                            <div class="col-12 pb-3">
                                                <div class="input-group has-success">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="nc-icon nc-key-25"></i></span>
                                                    </div>
                                                    <input type="password"
                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                        required placeholder="Confirm Password" name="password_confirmation"
                                                        aria-invalid="false">
                                                    @error('password_confirmation')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-footer">
                                    <div class="pull-right">
                                        <input type="submit" class="btn btn-next btn-fill btn-rose btn-wd valid"
                                            value="Update Password" aria-invalid="false" style="">

                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                        </div>
                        </form>

                    </div>
                </div>

            </div>
        </div> <!-- wizard container -->
    </div>
@endsection


@push('scripts')
    <script>
        var profilePictureInput = $('#wizard-picture');
        $('#profile_picture').on('click', function() {
            profilePictureInput[0].click();
        });

        profilePictureInput.on('change', function(event) {
            var file = profilePictureInput[0].files[0];
            var imagePreview = URL.createObjectURL(file);
            $('#wizardPicturePreview').attr('src', imagePreview);
        })
    </script>
@endpush
