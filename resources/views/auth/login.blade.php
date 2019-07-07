@extends('auth.layouts.main')

@section('title', 'Login')

@section('content')
<div class="middle-box text-center loginscreen animated fadeInDown">
    <div>
        <div><h1 class="logo-name">P/P</h1></div>
        <h3>Administration Panel</h3>
        <form class="m-t" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail address" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <div class="checkbox i-checks">
                    <label>
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><i></i> {{ __('Remember Me') }}
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Login') }}</button>

            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    <small>{{ __('Forgot Your Password?') }}</small>
                </a>
            @endif

            <p class="text-muted text-center"><small>Do not have an account?</small></p>
            <a class="btn btn-sm btn-white btn-block" href="{{ route('register') }}">{{ __('Create an account') }}</a>

        </form>

        <p class="m-t"> <small>&copy; 2019-{{ now()->year }}</small></p>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
@endpush
