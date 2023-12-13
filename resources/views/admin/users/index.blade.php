@extends('layouts.app-master')


@section('content')
<legend>{{ __('Users') }}</legend>
<div class="mt-2">
    @include('layouts.partials.messages')
</div>
<section class="products">
    <div class="products-topbar">
        <div class="products-add" style="visibility: hidden;">
            <a href="{{ route('users.create') }}">
                <li class="fa fa-plus"></li>
                <span>{{ __('Add User') }}</span>
            </a>
        </div>
        <form class="products-search" method="GET" action="{{ route('search.users') }}">
            @csrf
            <input type="search" name="user-search" placeholder="Search for User..." value="{{ request('user-search') }}" >
            <i class="fa fa-search"></i>
        </form>
    </div>
    <div class="products-listing table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col" width="5%">{{ __('ID') }}</th>
                    <th scope="col" width="20%">{{ __('Name') }}</th>
                    <th scope="col" width="20%">{{ __('Email') }}</th>
                    <th scope="col" width="20%">{{ __('Role') }}</th>
                    <th scope="col" width="20%">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>                                              
                        <td>{{ $user -> id }}</td>
                        <td>{{ $user -> name }}</td>
                        <td>{{ $user -> email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <button class="action btn btn-primary" onclick="location.href='{{ route('users.show', ['user' => $user->id]) }}'">
                                <i class="fas fa-eye"></i>
                            </button>                            
                            <button class="action btn btn-warning" onclick="location.href='{{ route('users.edit', ['user' => $user->id]) }}'" >
                                <i class="fas fa-edit"></i>
                            </button>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['users.destroy', $user->id],
                                'style' => 'display:inline',
                                'onsubmit' => 'return confirm("Are you sure you want to delete this user?");'
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
    {!! $users->links() !!}
</div>
@endsection
