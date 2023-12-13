@extends('layouts.app-master') {{-- Use your layout file if you have one --}}
@section('content')
<legend>{{__(('Show Banner'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<div class="show-category">
    <div class="form-category-header">
        <a href="{{ route('banners') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{__(('Go Back'))}}</span>
        </a>
        {{__(('Banner Info'))}}
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Title'))}}</div>
        <span>{{ $banner->title }}</span>
    </div>
     
    <div class="info-category">
        <div class="info-name" style="width: 30%">{{__(('Banner'))}}</div>
        <span>
            <div class="table-img" style="background-image: url('{{ asset("storage/images/admin/banners/" . $banner->banner) }}'); width: 100%; height: 60vh; margin: auto;"></div>
        </span>
    </div>   
    <div class="info-category">
        <div class="info-name">{{__(('description'))}}</div>
        <span>{{ $banner-> description }}</span>
    </div>   
    <div class="info-category">
        <div class="info-name">{{__(('Status'))}}</div>
        <span>{{ $banner-> status }}</span>
    </div> 
    <div class="info-action">
        <button class="action btn btn-warning" onclick="location.href='{{ route('edit.banners', ['id' => $banner->id]) }}'" >
            <i class="fas fa-edit"></i>
        </button>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['delete.banners', $banner->id],
            'style' => 'display:inline',
            'onsubmit' => 'return confirm("Are you sure you want to delete this banner?");'
        ]) !!}
        <button type="submit" class="action btn btn-danger">
            <i class="fas fa-trash"></i>
        </button>
        {!! Form::close() !!}
    </div>
</div>
@endsection
