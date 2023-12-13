@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>{{ ucfirst($role->name) }} Role</h1>
       
        <div class="container mt-4">
            <h3>Assigned permissions</h3>

            <table class="table table-striped">
                <thead>
                    <th scope="col" width="20%">Name</th>
                    <th scope="col" width="1%">Guard</th>
                </thead>

                @foreach($rolePermissions as $permission)
                    <tr>
                        <td>
                            @if(isset($permission->name))
                                {{ $permission->name }}
                            @else
                                N/A
                            @endif    
                        </td>
                        <td>
                            @if(isset($permission->guard_name))
                                {{ $permission->guard_name }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="mt-4">
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
    </div>
@endsection
