@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Show user</h1>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <div>
                Name: {{ $user->name }}
            </div>
            <div>
                Email: {{ $user->email }}
            </div>
            <div>
                Roles:
                @foreach($user->roles as $role)
                    {{ $role->name }}
                @endforeach
            </div>
            
        </div>

    </div>
    <div class="mt-4">
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
    </div>
@endsection