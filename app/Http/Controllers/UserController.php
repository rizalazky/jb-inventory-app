<?php

namespace App\Http\Controllers;

 
use App\DataTables\UsersDataTable;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
Use Alert;
 
class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        
        return $dataTable->render('user.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.create', [
            'roles' => $roles
        ]);
    }

    public function create_post(Request $request)
    {
        $user = User::create([
            'name' =>$request->name,
            'email' => $request->email,
            'password' => bcrypt($request->email)
        ]);

        $user->assignRole($request->role);
        
        Alert::success('Nice!', 'User Added!');
        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $user = User::with('roles')->find($id);
        // $user->role = $user->getRoleNames();
        $roles = Role::all();
        return view('user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function edit_post(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->syncRoles($request->role);

        Alert::success('Well done!', 'User Updated!');

        return redirect()->route('user.index');
    }

    public function delete($id){
        // $users = User::user('writer')->get();
        $user = User::find($id)->delete();
        Alert::success('Oke!', 'User Deleted!');

        return redirect()->route('user.index');
    }
}
