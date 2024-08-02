<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\View\View;
use App\DataTables\RoleDataTable;
Use Alert;

class RoleController extends Controller
{
    //
    
    public function index(RoleDataTable $dataTable)
    {
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return $dataTable->render('role.role');
    }

    public function create()
    {
        return view('role.create');
    }

    public function create_post(Request $request)
    {
        $role = Role::create(['name' =>$request->name]);
        
        Alert::success('Nice!', 'Role Added!');
        return redirect()->route('role.index');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return view('role.edit', [
            'role' => $role
        ]);
    }

    public function edit_post(Request $request)
    {
        $role = Role::find($request->id);
        $role->name = $request->name;
        $role->save();

        Alert::success('Well done!', 'Role Updated!');

        return redirect()->route('role.index');
    }

    public function delete($id){
        // $users = User::role('writer')->get();
        $role = Role::find($id)->delete();
        Alert::success('Oke!', 'Role Deleted!');

        return redirect()->route('role.index');
    }
}
