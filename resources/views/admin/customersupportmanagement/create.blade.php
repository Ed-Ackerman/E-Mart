@extends('layouts.app-master') <!-- Make sure to use the appropriate layout -->

@section('content')
<legend>{{__(('Answer FAQ'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<form class="form-category" method="POST" action="{{ route('store.faq') }}">
    @csrf
    <div class="form-category-header">
        <a href="{{ route('index.faq') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{__(('Go Back'))}}</span>
        </a>
        {{__(('Add FAQ'))}}
    </div>
    <div class="form-category-group">
        <label for="title">{{ __('FAQ Title :') }}</label>
        <input id="title" type="text"  @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
        @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror                           
    </div>
    <div class="form-category-group">
        <label for="question">{{ __('FAQ :') }}</label>
        <input id="question" type="text"  @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required autocomplete="question" autofocus>
        @error('question')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror                           
    </div>
    <div class="form-category-group">
        <label for="answer">{{ __('Answer :') }}</label>
        <textarea id="answer"  @error('answer') is-invalid @enderror" name="answer" rows="4">{{ old('answer') }}</textarea>
        @error('answer')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror                        
    </div>
    <button type="submit">
        <i class="fa fa-check"></i>
        {{ __('Submit FAQ') }}
    </button>
</form>
@endsection
