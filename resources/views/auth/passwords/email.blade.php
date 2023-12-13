@extends('layouts.auth')

@section('content')
<section class="auth">
    <div class="auth-logo-bg">
        <div class="auth-logo" style="background-image: url('{{ asset('admin/imgs/e-mart-2.PNG') }}')"></div>
    </div>
    <form method="POST" action="{{ route('password.update') }}">
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @csrf
        <div class="auth-title">{{__('Reset Password')}}</div>
       
        <div class="auth-field">
            <input id="email" type="email" class="auth-input @error('email') is-invalid @enderror" name="email" value="" required autocomplete="email" autofocus>
            <label for="email">{{__('Email')}}</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
       
        <div class="auth-field"> 
            <button type="submit" class="submit">
                {{ __('Send') }}
            </button>
            <u>{{__('Already have an Account')}}</u>
        </div>
        <hr>
      
        <button type="submit" onclick="window.location.href = '{{ route('login') }}';" class="register">
            {{ __('Login') }}
        </button>

    </form>
</section>
@endsection
