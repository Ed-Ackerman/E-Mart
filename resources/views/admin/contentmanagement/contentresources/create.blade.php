@extends('layouts.app-master') <!-- Make sure to use the appropriate layout -->

@section('content')
<legend>{{__(('Create Banner'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<form class="form-category" method="POST" action="{{ route('store.banners') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-category-header">
        <a href="{{ route('banners') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{__(('Go Back'))}}</span>
        </a>
        {{__(('Images'))}}
    </div>
    <div class="form-category-group">
        <label for="title">{{ __('Title :') }}</label>
        <input id="title" type="text"  @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
        @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror                           
    </div>
    <div class="form-category-group">
        <label for="banner">{{(__('Banner :'))}}</label>
        <div class="product-details-group image-input-container" id="img" style="width: 100%; height: 60vh; margin: auto;">
            <input type="file" name="banner" id="image" class="image-input" multiple>
            <label for="image">
                <li class="fas fa-upload"></li> 
                {{__(('Upload'))}}
            </label>
            <img id="preview" class="preview" width="100" height="100" />
            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
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
    <div class="form-category-group dropdown-check-list-size" tabindex="100">
        <label for="name">{{__(('Status *'))}}</label>
        <select name="status" id="status">
            <option disabled >{{__('Select Status')}}</option>
            <option value="active" selected>{{__('Active')}}</option>
            <option value="inactive">{{__('Inactive')}}</option>
        </select>
        @error('status')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <button type="submit">
        <i class="fa fa-check"></i>
        {{ __('Submit') }}
    </button>
</form>
@endsection
