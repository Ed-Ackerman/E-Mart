@extends('layouts.app-master')

@section('content')
    

    <div class="bg-light p-4 rounded">
        <h1>Roles</h1>
        <div class="lead">
            Manage your roles here.
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right">Add role</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        <div class="products-listing table-responsive">
            <table class="table table-bordered">
            <tr>
                <th scope="col" width="5%">{{ __('ID') }}</th>
                <th scope="col" width="20%">{{ __('Name') }}</th>
                <th scope="col" width="20%">{{ __('Action') }}</th>
            </tr>
                @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <button class="action btn btn-primary" onclick="location.href='{{ route('roles.show', ['role' => $role->id]) }}'">
                            <i class="fas fa-eye"></i>
                        </button>                            
                        <button class="action btn btn-warning" onclick="location.href='{{ route('roles.edit', ['role' => $role->id]) }}'" >
                            <i class="fas fa-edit"></i>
                        </button>
                        {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['roles.destroy', $role->id],
                            'style' => 'display:inline',
                            'onsubmit' => 'return confirm("Are you sure you want to delete this role?");'
                        ]) !!}
                            <button type="submit" class="action btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="pagination">
        {!! $roles->links() !!}
    </div>
@endsection