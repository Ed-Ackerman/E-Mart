@extends('layouts.app-master') {{-- Use your layout file if you have one --}}
@section('content')
<legend>{{__(('Show FAQ'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<div class="show-category">
    <div class="form-category-header">
        <a href="{{ route('help') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{__(('Go Back'))}}</span>
        </a>
        {{__(('FAQ Info'))}}
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Customer Name'))}}</div>
        <span>{{ $inquiry -> name }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Customer Tel'))}}</div>
        <span>{{ $inquiry -> tel }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Customer Email'))}}</div>
        <span>{{ $inquiry -> email }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Question'))}}</div>
        <span>{{ $inquiry -> inquiry }}</span>
    </div>    
    <div class="info-action">
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['delete.inquiry', $inquiry->id],
            'style' => 'display:inline',
            'onsubmit' => 'return confirm("Are you sure you want to delete this inquiry?");'
        ]) !!}
        <button type="submit" class="action btn btn-danger">
            <i class="fas fa-trash"></i>
        </button>
        {!! Form::close() !!}
    </div>
</div>
@endsection
