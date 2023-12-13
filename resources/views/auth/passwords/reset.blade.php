@extends('layouts.auth')

@section('content')


<section class="auth">
    <div class="auth-logo-bg">
        <div class="auth-logo" style="background-image: url('{{ asset('admin/imgs/e-mart-2.PNG') }}')"></div>
    </div>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="auth-title">{{__('Reset Password')}}</div>
       
        <div class="auth-field">
            <input id="email" type="email" class="auth-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            <label for="email">{{__('Email')}}</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="auth-field">
            <input id="password" type="password" class="auth-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            <label for="password">{{__('Password')}}</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>       
        <div class="auth-field">
            <input id="password" type="password" class="auth-input @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
            <label for="password">{{__('Confirm Password')}}</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>       
        
        <div class="auth-field">
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="box-shadow: none;">
            <label for="remember">{{ __('Remember Me') }}</label>
        </div>

        <div class="auth-field"> 
            <button type="submit" class="submit">
                {{ __('Login') }}
            </button>
            <u>{{__('Already have an Account')}}</u>
        </div>
        <hr>
      
        <button class="register" onclick="window.location.href = '{{ route('register') }}';">{{__('Sign Up')}}</button>

    </form>
</section>
@endsection
