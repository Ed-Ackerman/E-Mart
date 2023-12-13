@extends('layouts.app-master')

@section('content')
<legend>{{__(('All SubCategories'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="categories">
    <div class="categories-topbar">
        <div class="categories-add">
            <a href="{{ route('categories') }}">
                <li class="fa fa-eye"></li>
                <span>{{__(('Category'))}}</span>
            </a>
            <a href="{{ route('create.subcategories')  }}">
                <li class="fa fa-plus"></li>
                <span>{{__(('SubCategory'))}}</span>
            </a>
            <a href="{{ route('subsubcategories') }}">
                <li class="fa fa-eye"></li>
                <span>{{__(('Sub-SubCategory'))}}</span>
            </a>
        </div>
        <form class="categories-search" method="GET" action="{{ route('search.subcategories') }}">
            @csrf
            <input type="search" name="subcategory-search" placeholder="Search for SubCategory..." value="{{ request('subcategory-search') }}">
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="categories-listing table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{__('ID')}}</th>
                    <th scope="col" width="20%">{{__(('Name'))}}</th>
                    <th scope="col" width="20%">{{__(('Description'))}}</th>
                    <th scope="col" width="20%">{{__(('Action'))}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subcategories as $subcategory)
                    <tr>
                        <td>{{ $subcategory -> id }}</td>
                        <td>{{ $subcategory -> name }}</td>
                        <td>{{ $subcategory -> description }}</td>
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.subcategories', ['id' => $subcategory->id]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>                            
                            <button class="action btn btn-warning" onclick="location.href='{{ route('edit.subcategories', ['id' => $subcategory->id]) }}'" >
                                <i class="fas fa-edit"></i>
                            </button>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['delete.subcategories', $subcategory->id],
                                'style' => 'display:inline',
                                'onsubmit' => 'return confirm("Are you sure you want to delete this subcategory?");'
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
    {!! $subcategories->links() !!}
</div>
@endsection
