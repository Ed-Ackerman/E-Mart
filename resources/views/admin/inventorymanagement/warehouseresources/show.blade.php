@extends('layouts.app-master') <!-- Make sure to use the appropriate layout -->

@section('content')
<div class="container">
    <legend>{{ __('Warehouse Details') }}</legend>
    <div class="mt-2">
        @include('layouts.partials.messages')
    </div>
    <section class="show-product">
        <div class="product-header">
            <a href="{{ route('warehouse') }}">
                <i class="fa fa-arrow-left"></i>
                <span class="back" >{{__(('Go Back'))}}</span>
            </a>
            {{__(('Warehouse Info'))}}
        </div>
        <div class="product-info">
            <div class="product-details-info">
                <div class="info-name">{{__(('Warehouse ID No.'))}}</div>
                <span>{{ $warehouse->id }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Name'))}}</div>
                <span>{{ $warehouse->name }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Code'))}}</div>
                <span>{{ $warehouse->code }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Email'))}}</div>
                <span>{{ $warehouse->email }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Phone Number'))}}</div>
                <span>{{ $warehouse->tel }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Location'))}}</div>
                <span>{{ $warehouse->location }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Capacity'))}}</div>
                <span>{{ $warehouse->capacity }}</span>
            </div>
            <hr>
            <div class="product-details-info">
                <div class="info-name">{{__(('Categories'))}}</div>
                <span>
                    @foreach($warehouse->categories as $category)
                    {{ $category->name }}<br>
                    @endforeach
                </span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Products'))}}</div>
                <span>{{ $warehouse->product }}</span>
            </div>
            <hr>
            <div class="product-details-info">
                <div class="info-name">{{__(('Method of Payment'))}}</div>
                <span>
                    @foreach(explode(',', $warehouse->method) as $selectedMethod)
                    {{ __($selectedMethod) }}<br>
                    @endforeach    
                </span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Custom Payment'))}}</div>
                <span>
                    <span>{{  $warehouse->custom_method }}</span>
                </span>
            </div>        
            <hr>
            <div class="product-details-info">
                <div class="info-name">{{__(('Terms of Storage'))}}</div>
                <span>{{ $warehouse->terms }}</span>
            </div>
            <hr>
            <div class="product-details-info">
                <div class="info-name">{{__(('Terms of Payment'))}}</div>
                <span>{{ $warehouse->payment }}</span>
            </div>
        </div>
        <div class="info-action">
            <button class="action btn btn-warning" onclick="location.href='{{ route('edit.warehouse', ['id' => $warehouse->id]) }}'" >
                <i class="fas fa-edit"></i>
            </button>
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['delete.warehouse', $warehouse->id],
                'style' => 'display:inline',
                'onsubmit' => 'return confirm("Are you sure you want to delete this warehouse?");'
            ]) !!}
            <button type="submit" class="action btn btn-danger">
                <i class="fas fa-trash"></i>
            </button>
            {!! Form::close() !!}
        </div>
    </section>
</div>
@endsection