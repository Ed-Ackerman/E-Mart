@extends('layouts.app-master')

@section('content')
<legend>{{ __('Returns') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="products">
    <div class="products-topbar">
        <div class="products-add" style="visibility: hidden;">
            <a href="{{ route('create.suppliers') }}">
                <li class="fa fa-plus"></li>
                <span>{{ __('Add Supplier') }}</span>
            </a>
        </div>
        <form class="products-search" method="GET" action="{{ route('search.returns') }}">
            @csrf
            <input type="search" name="returns-search" placeholder="Search for Returns..." value="{{ request('returns-search') }}">
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{ __('ID') }}</th>
                    <th scope="col" width="20%">{{ __('Product Name') }}</th>
                    <th scope="col" width="20%">{{ __('Customer Name') }}</th>
                    <th scope="col" width="20%">{{ __('Status') }}</th>
                    <th scope="col" width="20%">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($returns as $return)
                    <tr>
                        <th scope="row">{{ $return->id }}</th>                                          
                        <td>{{ $return->product_name }}</td>
                        <td>{{ $return->name }}</td>
                        <td>
                            <div class="deliver">
                                @if ($return->return_status === 'approved')
                                    <div class="span approved-status">{{ __('Approved') }}</div>
                                @elseif ($return->return_status === 'pending')
                                    <div class="span pending-status">{{ __('Pending') }}</div>
                                @elseif ($return->return_status === 'denied')
                                    <div class="span denied-status">{{ __('Denied') }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.return', $return->id) }}'">
                                <i class="fas fa-eye"></i>
                            </button>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['delete.return', $return->id],
                                'style' => 'display:inline',
                                'onsubmit' => 'return confirm("Are you sure you want to delete this return?");'
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
    {!! $returns->links() !!}
</div>
@endsection

