@extends('layouts.app-master')

@section('content')
<legend>{{ __('Images') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="products">
    <div class="products-topbar">
        <div class="products-add">
            <a href="{{ route('create.banners') }}">
                <li class="fa fa-plus"></li>
                <span>{{ __('Add Image') }}</span>
            </a>
        </div>
        <form class="products-search" method="GET" action="">
            @csrf
            <input type="search" name="image-search" placeholder="Search for Image..." value="{{ request('image-search') }}">
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="products-listing table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{ __('ID') }}</th>
                    <th scope="col" width="20%">{{ __('Image') }}</th>
                    <th scope="col" width="20%">{{ __('Title') }}</th>
                    <th scope="col" width="20%">{{ __('Status') }}</th>
                    <th scope="col" width="20%">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $banner)
                    <tr>
                        <th scope="row">{{ $banner -> id }}</th>
                        <td>
                            <div class="table-img" style="background-image: url('{{ asset("storage/images/admin/banners/" . $banner->banner) }}');"></div>
                        </td>                                              
                        <td>{{ $banner -> title }}</td>                                              
                        <td>
                            @if ($banner->status === 'active')
                                <span style="background-color: #00ff15; border-radius: 50px; padding: 3px 6px; color: #fff; margin: auto auto;">{{ __('Active') }}</span>
                            @else
                                <span style="background-color: #ffdc17; border-radius: 50px; padding: 3px 6px; color: #000000; margin: auto auto;">{{ __('Inactive') }}</span>
                            @endif
                        </td>
                                                                   
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.banners', ['id' => $banner->id]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>                            
                            <button class="action btn btn-warning" onclick="location.href='{{ route('edit.banners', ['id' => $banner->id]) }}'" >
                                <i class="fas fa-edit"></i>
                            </button>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['delete.banners', $banner->id],
                                'style' => 'display:inline',
                                'onsubmit' => 'return confirm("Are you sure you want to delete this banner?");'
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
<div class="paginate">
    {!! $banners->links() !!}
</div> 
@endsection
