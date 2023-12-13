@extends('layouts.app-master')

@section('content')
<legend>{{ __('FAQs (Frequently Asked Questions)') }}</legend>
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
        </div>
        <form class="products-search" method="GET" action="{{ route('search.faq') }}">
            @csrf
            <input type="search" name="faq-search" placeholder="Search for FAQs..." value="{{ request('faq-search') }}">
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="products-listing table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{ __('ID') }}</th>
                    <th scope="col" width="20%">{{ __('Title') }}</th>
                    <th scope="col" width="20%">{{ __('Question') }}</th>
                    <th scope="col" width="20%">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faqs as $faq)
                    <tr>
                        <td>{{$faq -> id}}</td>
                        <td>{{$faq -> title}}</td>                                              
                        <td>{{$faq -> question}}</td>                                              
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.faq', ['id' => $faq->id]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>                            
                            <button class="action btn btn-warning" onclick="location.href='{{ route('edit.faq', ['id' => $faq->id]) }}'" >
                                <i class="fas fa-edit"></i>
                            </button>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['delete.faq', $faq->id],
                                'style' => 'display:inline',
                                'onsubmit' => 'return confirm("Are you sure you want to delete this FAQ?");'
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
    {!! $faqs->links() !!}
</div>
@endsection
