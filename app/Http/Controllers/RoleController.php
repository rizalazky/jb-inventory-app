<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use App\DataTables\RoleDataTable;
Use Alert;
use Illuminate\Support\Facades\Auth;

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
        $permissions = Permission::all();
        // dd($permissions);
        $groupedPermissions = $permissions->reduce(function ($carry, $permission) {
            $parts = explode(' ', $permission->name);

            if (count($parts) < 3) {
                return $carry;
            }

            [$menu, $subMenu] = $parts; // Extract the first two parts as menu and sub-menu
            
            $carry[$menu][$subMenu][] = $permission;

            return $carry;
        }, []);


        


        // dd($groupedPermissions);
        return view('role.edit', [
            'role' => $role,
            'permissions'=> $groupedPermissions,
            'user'=> Auth::user()
        ]);
    }

    public function permission(Request $request){
        $role_id= $request->role_id;
        $permission_name = $request->permission_name;
        $action = $request->action;


        $role= Role::find($role_id);
        if($action){
            $role->givePermissionTo($permission_name);
        }else{
            $role->revokePermissionTo($permission_name);
        }

        return redirect()->route('role.edit',[ 'id'=>$role_id]);
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
