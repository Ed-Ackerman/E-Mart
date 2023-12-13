@extends('layouts.app-master')

@section('content')
<legend>{{ __('Customer Inquiry') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="products">
    <div class="products-topbar">
        <div class="products-add">
            <a href="{{ route('create.faq') }}">
                <li class="fa fa-plus"></li>
                <span>{{ __('Add FAQ') }}</span>
            </a>
            <a href="{{ route('index.faq') }}">
                <li class="fa fa-eye"></li>
                <span>{{ __('FAQs') }}</span>
            </a>
        </div>
        <form class="products-search" method="GET" action="{{ route('search.inquiry') }}">
            @csrf
            <input type="search" name="inquiry-search" placeholder="Search for Customer Inquiry ..." value="{{ request('inquiry-search') }}">
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="products-listing table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{ __('ID') }}</th>
                    <th scope="col" width="20%">{{ __('Name') }}</th>
                    <th scope="col" width="20%">{{ __('Tel.') }}</th>
                    <th scope="col" width="20%">{{ __('Email') }}</th>
                    <th scope="col" width="20%">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inquiries as $inquiry)
                    <tr>
                        <td>{{$inquiry -> id}}</td>                                              
                        <td>{{ $inquiry -> name }}</td>
                        <td>{{ $inquiry -> tel }}</td>
                        <td>{{ $inquiry -> email }}</td>
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.inquiry', ['id' => $inquiry->id]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>     
        
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<div class="pagination">
    {!! $inquiries->links() !!}
</div>
@endsection
