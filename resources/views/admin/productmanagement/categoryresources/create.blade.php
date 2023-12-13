@extends('layouts.app-master') <!-- Make sure to use the appropriate layout -->

@section('content')
<legend>{{__(('Create Category'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<form class="form-category" method="POST" action="{{ route('store.categories') }}">
    @csrf
    <div class="form-category-header">
        <a href="{{ route('categories') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{__(('Go Back'))}}</span>
        </a>
        {{__(('Add Category'))}}
    </div>
    <div class="form-category-group">
        <label for="name">{{ __('Category Name :') }}</label>
        <input id="name" type="text"  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror                           
    </div>
    <div class="form-category-group">
        <label for="description">{{ __('Description :') }}</label>
        <textarea id="description"  @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror                        
    </div>
    <button type="submit">
        <i class="fa fa-check"></i>
        {{ __('Create Category') }}
    </button>
</form>
@endsection
