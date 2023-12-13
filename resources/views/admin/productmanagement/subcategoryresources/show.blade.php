@extends('layouts.app-master') {{-- Use your layout file if you have one --}}
@section('content')
<legend>{{__(('Show SubCategory'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<div class="show-category">
    <div class="form-category-header">
        <a href="{{ route('subcategories') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{__(('Go Back'))}}</span>
        </a>
        {{__(('SubCategory Info'))}}
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Name'))}}</div>
        <span>{{ $subcategory->name }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Description'))}}</div>
        <span>{{ $subcategory->description }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Parent Categories'))}}</div>
        <ol>
            @forelse($subcategory->categories as $category)
                <li>{{ $category->name }}</li>
                @empty
                <li>{{ __('No Categories Found...') }}</li>
            @endforelse
        </ol>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Sub Sub-Categories'))}}</div>
        <ol>
            @forelse($subcategory->subsubcategories as $subsubcategory)
                <li>{{ $subsubcategory->name }}</li>
                @empty
                <li>{{ __('No Sub-Subcategories Found...') }}</li>
            @endforelse
        </ol>
    </div>
   
    <div class="info-action">
        <button class="action btn btn-warning" onclick="location.href='{{ route('edit.subcategories', ['id' => $subcategory->id]) }}'" >
            <i class="fas fa-edit"></i>
        </button>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['delete.subcategories', $subcategory->id],
            'style' => 'display:inline',
            'onsubmit' => 'return confirm("Are you sure you want to delete this subcategory?");'
        ]) !!}
        <button type="submit" class="action btn btn-danger">
            <i class="fas fa-trash"></i>
        </button>
        {!! Form::close() !!}
    </td>
    </div>
</div>
@endsection
