@extends('layouts.app-master') <!-- Make sure to use the appropriate layout -->

@section('content')
<div class="container">
    <h2>{{ __('Supplier Details') }}</h2>
    <div class="mt-2">
        @include('layouts.partials.messages')
    </div>
    <section class="show-product">
        <div class="product-header">
            <a href="{{ route('suppliers') }}">
                <i class="fa fa-arrow-left"></i>
                <span class="back" >{{__(('Go Back'))}}</span>
            </a>
            {{__(('Supplier Info'))}}
        </div>
        <div class="product-info">
            <div class="product-details-info">
                <div class="info-name">{{__(('Supplier ID No.'))}}</div>
                <span>{{ $supplier->id }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Name'))}}</div>
                <span>{{ $supplier->name }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Code'))}}</div>
                <span>{{ $supplier->code }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Email'))}}</div>
                <span>{{ $supplier->email }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Phone Number'))}}</div>
                <span>{{ $supplier->tel }}</span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Location'))}}</div>
                <span>{{ $supplier->location }}</span>
            </div>
            <hr>
            <div class="product-details-info">
                <div class="info-name">{{__(('Categories'))}}</div>
                <span>
                    @foreach($supplier->categories as $category)
                    {{ $category->name }}<br>
                    @endforeach
                </span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Products'))}}</div>
                <span>{{ $supplier->product }}</span>
            </div>
            <hr>
            <div class="product-details-info">
                <div class="info-name">{{__(('Method of Payment'))}}</div>
                <span>
                    @foreach(explode(',', $supplier->method) as $selectedMethod)
                    {{ __($selectedMethod) }}<br>
                    @endforeach    
                </span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Custom Payment'))}}</div>
                <span>
                    <span>{{  $supplier->custom_method }}</span>
                </span>
            </div>
            <hr>
            <div class="product-details-info">
                <div class="info-name">{{__(('Lead Time'))}}</div>
                <span>
                    @foreach(explode(',', $supplier->lead) as $selectedLead)
                    {{ __($selectedLead) }}<br>
                    @endforeach    
                </span>
            </div>
            <div class="product-details-info">
                <div class="info-name">{{__(('Custom Lead'))}}</div>
                <span>
                    <span>{{  $supplier->custom_lead }}</span>
                </span>
            </div>
            <hr>
            <div class="product-details-info">
                <div class="info-name">{{__(('Terms of Supply'))}}</div>
                <span>{{ $supplier->terms }}</span>
            </div>
            <hr>
            <div class="product-details-info">
                <div class="info-name">{{__(('Terms of Payment'))}}</div>
                <span>{{ $supplier->payment }}</span>
            </div>
        </div>
        <div class="info-action">
            <button class="action btn btn-warning" onclick="location.href='{{ route('edit.suppliers', ['id' => $supplier->id]) }}'" >
                <i class="fas fa-edit"></i>
            </button>
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['delete.suppliers', $supplier->id],
                'style' => 'display:inline',
                'onsubmit' => 'return confirm("Are you sure you want to delete this supplier?");'
            ]) !!}
                <button type="submit" class="action btn btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            {!! Form::close() !!}
        </div>
    </section>
</div>
@endsection