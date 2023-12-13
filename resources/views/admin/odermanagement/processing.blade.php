@extends('layouts.app-master')

@section('content')
<legend>{{ __('Orders') }}</legend>
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
        <form class="products-search" method="GET" action="{{ route('search.orders') }}">
            @csrf
            <input type="search" name="order-search" placeholder="Search for Orders..." value="{{ request('order-search') }}">
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{ __('ID') }}</th>
                    <th scope="col" width="20%">{{ __('Name') }}</th>
                    <th scope="col" width="20%">{{ __('Location') }}</th>
                    <th scope="col" width="20%">{{ __('Status') }}</th>
                    <th scope="col" width="20%">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>                                          
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->city }}</td>
                        <td>
                            <div class="deliver">
                                @if ($order->order_status === 'fulfilled')
                                    <div class="span approved-status">{{ __('Fulfilled') }}</div>
                                @elseif ($order->order_status === 'pending')
                                    <div class="span pending-status">{{ __('Pending') }}</div>
                                @elseif ($order->order_status === 'canceled')
                                    <div class="span canceled-status">{{ __('Canceled') }}</div>
                                @endif
                            </div>
                        </td>
                        
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.order', $order->id) }}'">
                                <i class="fas fa-eye"></i>
                            </button>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['delete.order', $order->id],
                                'style' => 'display:inline',
                                'onsubmit' => 'return confirm("Are you sure you want to delete this order?");'
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
    {!! $orders->links() !!}
</div>
@endsection
