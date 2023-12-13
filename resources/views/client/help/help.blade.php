@extends('layouts.app')

@section('content')

<section class="help">
    <form action="{{ route('client.inquiry') }}" class="faq-search" method="GET">
        @csrf
        <input type="text" placeholder="Search Keyword" name="inquiry-search" value="{{ request('inquiry-search') }}">
        <button type="submit">
            <i class="fa fa-search"></i>
        </button>
    </form>
    
    <hr>
    <div class="mt-2">
        @include('layouts.partials.messages')
    </div>
    
    <div class="client-helper">
        <div class="client-faq">
            <div class="faqs">
                @foreach ($faqs as $faq)
                <div class="faq-item">
                    <div class="faq-question">{{ $faq -> question }}</div>
                    <div class="icon-container"><i class="fas fa-chevron-right"></i></div>
                </div>
                <div class="faq-answer">
                    <i>{{ $faq -> answer }}.</i>
                </div>
                @endforeach
            </div>
        </div>
        <form action="{{ route('send.inquiry') }}" class="helper" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="auth-title inq">{{__('Want To Inquiry About Something...')}}</div>
            <div class="auth-field">
                <input id="name" type="text" class="auth-input @error('name') is-invalid @enderror" name="name" required autocomplete="current-name">
                <label for="name">{{__('Full Name')}}</label>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>   
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
                <input id="tel" type="text" class="auth-input @error('tel') is-invalid @enderror" name="tel" value="{{ old('tel') }}" required autocomplete="tel">
                <label for="tel">{{__('Tel.')}}</label>
                @error('tel')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="auth-field">
                <textarea id="inquiry" type="text" class="auth-input @error('inquiry') is-invalid @enderror" name="inquiry" value="{{ old('inquiry') }}" required autocomplete="inquiry" style="border: 1px solid #333; height: 30vh" ></textarea>
                <label for="inquiry">{{__('Inquiry.')}}</label>
                @error('inquiry')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="auth-field">
                <button type="submit" class="send">
                    {{ __('Send') }}
                </button>
            </div>
        </form>
    </div>
</section>

@endsection