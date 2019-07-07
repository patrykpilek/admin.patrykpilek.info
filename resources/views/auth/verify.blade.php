@extends('auth.layouts.main')

@section('title', 'Verify Email')

@section('content')
<div class="passwordBox animated fadeInDown">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center"><h1 class="logo-name">P/P</h1></div>
            @if (session('resent'))
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif
            <div class="ibox-content">
                <h2 class="font-bold">{{ __('Verify Your Email Address') }}</h2>
                <div class="row">
                    <div class="col-lg-12">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="col-md-6">
            admin.patrykpilek.info
        </div>
        <div class="col-md-6 text-right">
            <small>&copy; 2019-{{ now()->year }}</small>
        </div>
    </div>
</div>
@endsection
