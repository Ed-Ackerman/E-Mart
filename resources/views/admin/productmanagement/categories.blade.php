@extends('layouts.app-master')

@section('content')
<legend>{{__(('All Categories'))}}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="categories">
    <div class="categories-topbar">
        <div class="categories-add">
            <a href="{{ route('create.categories') }}">
                <li class="fa fa-plus"></li>
                <span>{{__(('Category'))}}</span>
            </a>
            <a href="{{ route('subcategories') }}">
                <li class="fa fa-eye"></li>
                <span>{{__(('SubCategory'))}}</span>
            </a>
            <a href="{{ route('subsubcategories') }}">
                <li class="fa fa-eye"></li>
                <span>{{__(('Sub-SubCategory'))}}</span>
            </a>
        </div>
        <form class="categories-search" method="GET" action="{{ route('search.categories') }}">
            @csrf
            <input type="search" name="category-search" placeholder="Search for Category..." value="{{ request('category-search') }}">
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
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category ->  id }}</td>
                        <td>{{ $category ->  name }}</td>
                        <td>{{ $category ->  description }}</td>
                        <td class="actions">
                            <button class="action btn btn-primary" onclick="location.href='{{ route('show.categories', ['id' => $category->id]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>                            
                            <button class="action btn btn-warning" onclick="location.href='{{ route('edit.categories', ['id' => $category->id]) }}'" >
                                <i class="fas fa-edit"></i>
                            </button>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['delete.categories', $category->id],
                                'style' => 'display:inline',
                                'onsubmit' => 'return confirm("Are you sure you want to delete this category?");'
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
    {!! $categories->links() !!}
</div>
@endsection
