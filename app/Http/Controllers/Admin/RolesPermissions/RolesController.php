<?php

namespace App\Http\Controllers\Admin\RolesPermissions;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * construct to define who has access to this controller and what the can do
     */
    public function __construct()
    {
        $this->middleware(['role:admin|manager']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $roles = Role::orderBy('id', 'DESC') -> paginate(5);
        return view('admin.roles.index')
            ->with(compact('roles'))
            ->with('i',($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $permissions = Permission::get();
        return view('admin.roles.create')
            ->with(compact('permissions'));
        $role = Role::get();
        return view('admin.roles.create')
            ->with(compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->get('name')]);
        $role -> syncPermissions($request -> get('permission'));

        return redirect() 
            -> route('roles.index')
            -> withSuccess(__('Role Created Successfully...'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
        $role = $role;
        $rolePermissions = $role->permissions;

        return view('admin.roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        $role = $role;
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::get();

        return view('admin.roles.show')
            ->with(compact('role', 'rolePermissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role -> update($request->only('name'));
        $role->syncPermissions($request -> get('permission'));
        return redirect()
            ->route('roles.index')
            ->withSuccess(__('Role Updated Successfully...'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $role -> delete();
        return redirect()
            ->route('roles.index')
            ->withSuccess(__('Role Deleted Successfully...'));
    }
}