@extends('layouts.main-app')
@section('content')
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="mx-auto" style="width: 568px;">
            <div class="card text-start">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="name" class="form-control @error('name') is-invalid @enderror" id="name"
                                aria-describedby="nameHelp" name="name" value="{{ old('name') }}" required
                                autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email address') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                aria-describedby="emailHelp" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword" class="form-label">{{ __('Password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="exampleInputPassword">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPasswordConfirm"
                                class="form-label">{{ __('Confirm Password') }}</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" id="exampleInputPasswordConfirm">
                            @error('password_confirmation')
                                password
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
