@extends('layouts.app-master')

@section('content')
<legend>{{ __('Suppliers') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="products">
    <div class="products-topbar">
        <div class="products-add">
            <a href="{{ route('create.suppliers') }}">
                <li class="fa fa-plus"></li>
                <span>{{ __('Add Supplier') }}</span>
            </a>
        </div>
        <form class="products-search" method="GET" action="{{ route('search.suppliers') }}">
            @csrf
            <input type="search" name="supplier-search" placeholder="Search for Supplier..." value="{{ request('supplier-search') }}">
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="products-listing">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{ __('ID') }}</th>
                    <th scope="col" width="20%">{{ __('Name') }}</th>
                    <th scope="col" width="20%">{{ __('Contact') }}</th>
                    <th scope="col" width="20%">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>                                              
                        <td>{{ $supplier -> id }}</td>
                        <td>{{ $supplier -> name }}</td>
                        <td>{{ $supplier -> tel }}</td>
                       
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.suppliers', ['id' => $supplier->id]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>                            
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
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<div class="pagination">
    {!! $suppliers->links() !!}
</div>
@endsection
