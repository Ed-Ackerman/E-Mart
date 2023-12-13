@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Permissions</h2>
        <div class="lead">
            Manage your permissions here.
            <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm float-right">Add permissions</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
            
                <th scope="col" width="5%">{{ __('ID') }}</th>
                <th scope="col" width="20%">{{ __('Name') }}</th>
                <th scope="col" width="20%">{{ __('Guard') }}</th>
                <th scope="col" width="20%">{{ __('Action') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>                      
                            <button class="action btn btn-warning" onclick="location.href='{{ route('permissions.edit', ['permission' => $permission->id]) }}'" >
                                <i class="fas fa-edit"></i>
                            </button>
                            {!! Form::open([
                                'method' => 'DELETE',
                                'route' => ['permissions.destroy', $permission->id],
                                'style' => 'display:inline',
                                'onsubmit' => 'return confirm("Are you sure you want to delete this permission?");'
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
@endsection