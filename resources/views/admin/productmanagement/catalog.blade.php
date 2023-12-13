@extends('layouts.app-master')

@section('content')
<legend>{{ __('Product Catalog') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="products">
    <div class="products-topbar">
        <div class="products-add">
            <a href="{{ route('create.product') }}">
                <li class="fa fa-plus"></li>
                <span>{{ __('Add Product') }}</span>
            </a>
        </div>
        <form class="products-search" method="GET" action="{{ route('search.product') }}">
            @csrf
            <input type="search" name="product-search" placeholder="Search for Product..." value="{{ request('product-search') }}">
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
                    <th scope="col" width="20%">{{ __('Category') }}</th>
                    <th scope="col" width="20%">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
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
                            @forelse($product->categories as $category)
                            {{ $category->name }} ,
                            @empty
                            <i>{{ __('No Categories Found...') }}</i>
                            @endforelse    
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
