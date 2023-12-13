@extends('layouts.app-master')

@section('content')
<legend>{{__(('Show Sub-SubCategory'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<div class="show-category">
    <div class="form-category-header">
        <a href="{{ route('subsubcategories') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{__(('Go Back'))}}</span>
        </a>
        {{__(('Sub-SubCategory Info'))}}
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Name'))}}</div>
        <span>{{ $subsubcategory->name }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Description'))}}</div>
        <span>{{ $subsubcategory->description }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{ __('Parent Categories') }}</div>
        <ol>
            @forelse($subsubcategory->categories as $category)
                <li>{{ $category->name }}</li>
                @empty
                <li>{{ __('No Categories Found...') }}</li>
            @endforelse
        </ol>
    </div>
    
    <div class="info-category">
        <div class="info-name">{{ __('Sub-Categories') }}</div>
        <ol>
            @forelse($subsubcategory->subcategories as $subCategory)
                <li>{{ $subCategory->name }}</li>
                @empty
                <li>{{ __('No Subcategories Found...') }}</li>
            @endforelse
        </ol>
    </div>
       
    <div class="info-action">
        <button class="action btn btn-warning" onclick="location.href='{{ route('edit.subsubcategories', ['id' => $subsubcategory->id]) }}'" >
            <i class="fas fa-edit"></i>
        </button>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['delete.subsubcategories', $subsubcategory->id],
            'style' => 'display:inline',
            'onsubmit' => 'return confirm("Are you sure you want to delete this subsubcategory?");'
        ]) !!}
        <button type="submit" class="action btn btn-danger">
            <i class="fas fa-trash"></i>
        </button>
        {!! Form::close() !!}
    </td>
    </div>
</div>
@endsection
