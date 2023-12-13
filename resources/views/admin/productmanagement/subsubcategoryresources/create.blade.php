@extends('layouts.app-master')

@section('content')
<legend>{{ __('Create Sub-Subcategory') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<form class="form-category" method="POST" action="{{ route('store.subsubcategories') }}">
    @csrf
    <div class="form-category-header">
        <a href="{{ route('subsubcategories') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{ __('Go Back') }}</span>
        </a>
        {{ __('Add Sub-Subcategory') }}
    </div>
    <div class="form-category-group">
        <label for="name">{{ __('Sub-Subcategory Name:') }}</label>
        <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-category-group">
        <label for="description">{{ __('Description:') }}</label>
        <textarea id="description" class="@error('description') is-invalid @enderror" name="description" rows="4">{{ old('description') }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-category-group">
        <label>{{ __('Sub Categories:') }}</label>
        <div class="form-check-host" style="width: 100%">
            @foreach($subcategories as $subcategory)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="subcategory_{{ $subcategory->id }}" name="subcategory_ids[]" value="{{ $subcategory->id }}">
                <div style="width 100%;"  class="form-check-label" for="subcategory_{{ $subcategory->id }}">{{ $subcategory->name }}</div>
            </div>
            @endforeach
        </div>
        @error('subcategory_ids')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    
    </div>
    <button type="submit">
        <i class="fa fa-check"></i>
        {{ __('Create Sub-Subcategory') }}
    </button>
</form>
@endsection
