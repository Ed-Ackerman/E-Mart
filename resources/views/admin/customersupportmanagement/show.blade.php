@extends('layouts.app-master') {{-- Use your layout file if you have one --}}
@section('content')
<legend>{{__(('Show FAQ'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>

<div class="show-category">
    <div class="form-category-header">
        <a href="{{ route('index.faq') }}">
            <i class="fa fa-arrow-left"></i>
            <span>{{__(('Go Back'))}}</span>
        </a>
        {{__(('FAQ Info'))}}
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Title'))}}</div>
        <span>{{ $faq->title }}</span>
    </div>
    <div class="info-category">
        <div class="info-name">{{__(('Question'))}}</div>
        <span>{{ $faq->question }}</span>
    </div>   
    <div class="info-category">
        <div class="info-name">{{__(('Answer'))}}</div>
        <span>{{ $faq->answer }}</span>
    </div>   
    <div class="info-action">
        <button class="action btn btn-warning" onclick="location.href='{{ route('edit.faq', ['id' => $faq->id]) }}'" >
            <i class="fas fa-edit"></i>
        </button>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['delete.faq', $faq->id],
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
