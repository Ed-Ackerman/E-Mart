@extends('layouts.app-master')

@section('content')
<legend>{{ __('Warehouses') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="products">
    <div class="products-topbar">
        <div class="products-add">
            <a href="{{ route('create.warehouse') }}">
                <li class="fa fa-plus"></li>
                <span>{{ __('Add Warehouse') }}</span>
            </a>
        </div>
        <form class="products-search" method="GET" action="{{ route('search.warehouse') }}">
            @csrf
            <input type="search" name="warehouse-search" placeholder="Search for Warehouse..." value="{{ request('warehouse-search') }}">
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="products-listing">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{ __('ID') }}</th>
                    <th scope="col" width="20%">{{ __('Name') }}</th>
                    <th scope="col" width="20%">{{ __('Products') }}</th>
                    <th scope="col" width="20%">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($warehouses as $warehouse)
                    <tr>                                              
                        <td>{{ $warehouse -> id }}</td>
                        <td>{{ $warehouse -> name }}</td>
                        <td>{{ $warehouse -> product }}</td>
                       
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.warehouse', ['id' => $warehouse->id]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>                            
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<div class="pagination">
    {!! $warehouses->links() !!}
</div>
@endsection
