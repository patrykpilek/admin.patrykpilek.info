@extends('auth.layouts.main')

@section('title', 'Register')

@section('content')
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div><h1 class="logo-name">P/P</h1></div>
        <h3>Administration Panel</h3>
        <p>Create account.</p>
        <form class="m-t" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail Address" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group ">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Register') }}</button>

            <p class="text-muted text-center"><small>Already have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="{{ route('login') }}">{{ __('Login') }}</a>

        </form>

        <p class="m-t"> <small>&copy; 2019-{{ now()->year }}</small> </p>
    </div>
</div>
@endsection
