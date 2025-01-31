<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = Group::with('permissions')->get();
        return view('admin.roles.create', compact('groups'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'permissions' => 'required',
        ]);
        $role = Role::create($data);
        $role->permissions()->attach($request->permissions);

        return redirect()->route('roles.index')->with('create', 'Created');
    }

    public function edit(Role $role)
    {
        $groups = Group::with('permissions')->get();

        return view('admin.roles.edit', compact('role', 'groups'));
    }


    public function update(Request $request, Role $role)
    {
        $role->name = $request->name;
        $role->permissions()->sync($request->permissions);
        $role->save();
        return redirect()->route('roles.index')->with('update', 'Updated');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $destroy = Role::findOrFail($id);
        $destroy->delete();
        return redirect()->route('roles.index')->with('delete', 'deleted');
    }
    public function status(Request $request, Role $role)
    {
        if ($role) {
            $role->status = !$role->status;
            $role->save();
        }

        return redirect()->route('roles.index')->with('update', 'Status updated');
    }

}
