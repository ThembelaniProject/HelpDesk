<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    /**
     * Display roles
     */
    public function index()
    {
        $roles = Role::withCount('users')
            ->latest()
            ->paginate(10);

        return view('roles.index', compact('roles'));
    }


    /**
     * Show create form
     */
    public function create()
    {
        return view('roles.create');
    }


    /**
     * Store role
     */
    public function store(Request $request)
    {

        $request->validate([

            'name'=>'required|unique:roles|max:255'

        ]);


        Role::create([

            'name'=>$request->name

        ]);


        return redirect()
            ->route('roles.index')
            ->with('success','Role created successfully.');

    }



    /**
     * Show role
     */
    public function show(Role $role)
    {
        return view('roles.show',compact('role'));
    }



    /**
     * Edit role
     */
    public function edit(Role $role)
    {
        return view('roles.edit',compact('role'));
    }



    /**
     * Update role
     */
    public function update(Request $request, Role $role)
    {

        $request->validate([

            'name'=>'required|unique:roles,name,'.$role->id

        ]);


        $role->update([

            'name'=>$request->name

        ]);


        return redirect()
            ->route('roles.index')
            ->with('success','Role updated successfully.');

    }



    /**
     * Delete role
     */
    public function destroy(Role $role)
    {

        // Prevent deleting roles with users

        if($role->users()->count() > 0)
        {

            return back()
            ->with('error',
            'Cannot delete role assigned to users.');

        }


        $role->delete();


        return redirect()
            ->route('roles.index')
            ->with('success',
            'Role deleted successfully.');

    }

}