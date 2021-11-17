@extends('layouts.app')

@section('content')
    <div class="bg-login">
        <div class="row justify-content-center">
            <div class="col-md-4 p-0 pack-login">
                <div class="card container-login">
                    {{-- <div class="card-header">{{ __('Login') }}</div> --}}

                    <div class="card-body">
                        <h3 class="text-center"><img src="{{ asset('icon.png') }}" class="navbar-brand"
                                style="width: 60px; height:70px">JakPintas Survei
                        </h3>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                {{-- <label for="email"
                                    class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> --}}

                                <div class="col-md-10 mx-auto">
                                    <label class="font-weight-bold text-left">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-none">
                                            <span class="input-group-text" id="addon-wrapping"><i
                                                    class="fa fa-envelope"></i></span>
                                        </div>
                                        <input id="email" type="email"
                                            class="form-control form-login @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" required autocomplete="email"
                                            placeholder="Input Your Email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                {{-- <label for="password"
                                    class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> --}}

                                <div class="col-md-10 mx-auto">
                                    <label class="font-weight-bold text-left">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-none">
                                            <span class="input-group-text" id="addon-wrapping"><i
                                                    class="fa fa-lock"></i></span>
                                        </div>
                                        <input id="password" type="password"
                                            class="form-control form-login @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password"
                                            placeholder="Input Your Password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-10 mx-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <div class="col-md-10 mx-auto">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-sign-in"></i> {{ __('Login') }}
                                    </button>
                                    <a href="{{ route('login-google') }}" class="btn btn-danger">
                                        <i class="fa fa-google" aria-hidden="true"></i> {{ __('Login with Google') }}
                                    </a>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
