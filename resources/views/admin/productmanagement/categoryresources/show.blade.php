@extends('layouts.app-master') {{-- Use your layout file if you have one --}}
@section('content')
<legend>{{__(('Show Category'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<div class="show-category">
    <div class="form-category-header">
        <a href="{{ route('categories') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{__(('Go Back'))}}</span>
        </a>
        {{__(('Category Info'))}}
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Name'))}}</div>
        <span>{{ $category->name }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Description'))}}</div>
        <span>{{ $category->description }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Sub Categories'))}}</div>
        <ol>
            @forelse($category->subcategories as $subcategory)
                <li>{{ $subcategory->name }}</li>
                @empty
                <li>{{ __('No Subcategories Found...') }}</li>
            @endforelse
        </ol>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Sub Sub-Categories'))}}</div>
        <ol>
            @forelse($category->subsubcategories as $subsubcategory)
                <li>{{ $subsubcategory->name }}</li>
                @empty
                <li>{{ __('No Sub-Subcategories Found...') }}</li>
            @endforelse
        </ol>
    </div>
   
    <div class="info-action">
        <button class="action btn btn-warning" onclick="location.href='{{ route('edit.categories', ['id' => $category->id]) }}'" >
            <i class="fas fa-edit"></i>
        </button>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['delete.categories', $category->id],
            'style' => 'display:inline',
            'onsubmit' => 'return confirm("Are you sure you want to delete this category?");'
        ]) !!}
        <button type="submit" class="action btn btn-danger">
            <i class="fas fa-trash"></i>
        </button>
        {!! Form::close() !!}
    </div>
</div>
@endsection
