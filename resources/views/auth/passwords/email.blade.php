@extends('auth.layouts.main')

@section('title', 'Forgot password')

@section('content')
<div class="passwordBox animated fadeInDown">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        {{ session('status') }}
                    </div>
                @endif
                <h2 class="font-bold">{{ __('Forgot password') }}</h2>
                <p>Enter your email address and your password reset link will be emailed to you.</p>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email address"  required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Send Password Reset Link') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">admin.patrykpilek.com</div>
        <div class="col-md-6 text-right">
            <small>© 2019-{{ now()->year }}</small>
        </div>
    </div>
</div>
@endsection
