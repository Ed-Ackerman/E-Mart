@extends('layouts.app-master')

@section('content')
<legend>{{ __('Stock Level Metrics') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="products">
    <div class="products-topbar">
        <div class="products-add">
            <a href="{{ route('create.product') }}">
                <i class="fas fa-plus"></i>
                <span>{{ __('Add_Stock') }}</span>
            </a>
            <a href="{{ route('levels') }}" style="background-color: #c917ff;">
                <i class="fas fa-clipboard-list"></i>
                <span>{{ __('All_Stock') }}</span>
            </a>
            <a href="{{ route('reorder.products') }}" style="background-color: #ffdc17;">
                <i class="fas fa-sync fa-spin"></i>
                <span>{{ __('Re_Order') }}</span>
            </a>
            <a href="{{ route('outofstock.products') }}" style="background-color: #ff0000;"> 
                <i class="fas fa-ban fa-spin"></i>
                <span>{{ __('Out_of_Stock') }}</span>
            </a>
            <a href="{{ route('instock.products') }}" style="background-color: #00ff15;">
                <i class="fas fa-check-circle fa-spin"></i>
                <span>{{ __('In_Stock') }}</span>
            </a>
        </div>
        
        <form class="products-search" method="GET" action="{{ route('search.level') }}">
            @csrf
            <input type="search" name="level-search" placeholder="Search for Product..." value="{{ request('level-search') }}">
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="products-listing table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{ __('ID') }}</th>
                    <th scope="col" width="20%">{{ __('Img') }}</th>
                    <th scope="col" width="20%">{{ __('Name') }}</th>
                    <th scope="col" width="20%">{{ __('Levels') }}</th>
                    <th scope="col" width="20%">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>
                            @if ($product->image)
                                @php
                                    $imagePaths = explode(',', $product->image);
                                @endphp
                        
                                @if (!empty($imagePaths[0]))
                                    <div class="table-img" style="background-image: url('{{ asset('/storage/images/admin/product/' . trim($imagePaths[0])) }}');"></div>
                                @endif
                            @endif
                        </td>
                                              
                        <td>{{ $product->name }}</td>
                        <td>
                            @if ($product->quantity == 0)
                                <span style="background-color: #ff0000; border-radius: 50px; width: 100%; padding: 3px 6px; color: #fff;">{{__('Out_of_Stock')}}</span>
                            @elseif ($product->quantity <= $product->alert_threshold && (int)$product->quantity > 0)
                                <span style="background-color: #ffdc17; border-radius: 50px; width: 100%; padding: 3px 6px; color: #000000;">{{__('Needs_Reorder')}}</span>
                            @else
                                <span style="background-color: #00ff15; border-radius: 50px; width: 100%; padding: 3px 6px; color: #fff;">{{__('In_Stock')}}</span>
                            @endif
                        </td>
                        
                        
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.product', ['id' => $product->id]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>                            
                            <button class="action btn btn-warning" onclick="location.href='{{ route('edit.product', ['id' => $product->id]) }}'" >
                                <i class="fas fa-edit"></i>
                            </button>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['delete.product', $product->id],
                                'style' => 'display:inline',
                                'onsubmit' => 'return confirm("Are you sure you want to delete this product?");'
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
    {!! $products->links() !!}
</div>
@endsection
