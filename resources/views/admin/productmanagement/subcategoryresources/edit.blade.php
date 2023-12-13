@extends('layouts.app-master')

@section('content')
<legend>{{ __('Edit Subcategory') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<form class="form-category" method="POST" action="{{ route('update.subcategories', ['id' => $subcategory->id]) }}">

    @csrf
    @method('PUT') <!-- Use the PUT method for updating -->

    <div class="form-category-header">
        <a href="{{ route('subcategories') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{ __('Go Back') }}</span>
        </a>
        {{ __('Edit Subcategory') }}
    </div>

    <div class="form-category-group">
        <label for="name">{{ __('Subcategory Name:') }}</label>
        <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name', $subcategory->name) }}" required autocomplete="name" autofocus>
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-category-group">
        <label for="description">{{ __('Description:') }}</label>
        <textarea id="description" class="@error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $subcategory->description) }}</textarea>
        @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-category-group">
        <label>{{ __('Parent Categories:') }}</label>
        <div class="form-check-host">
            @foreach($categories as $category)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="category_{{ $category->id }}" name="category_ids[]" value="{{ $category->id }}" {{ in_array($category->id, $subcategory->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                <div class="form-check-label" for="category_{{ $category->id }}">{{ $category->name }}</div>
            </div>
            @endforeach
        </div>
        @error('category_ids')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button type="submit">
        <i class="fa fa-check"></i>
        {{ __('Update Subcategory') }}
    </button>
</form>
@endsection
