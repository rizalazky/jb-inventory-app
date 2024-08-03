<?php

namespace App\Http\Controllers;

 
use App\DataTables\CustomerDataTable;
use App\Models\Customer;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
Use Alert;
 
class CustomerController extends Controller
{
    public function index(CustomerDataTable $dataTable)
    {
        $title = 'Delete Customer!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        
        return $dataTable->render('customer.index');
    }

    public function create()
    {
        return view('customer.create');
    }

    public function create_post(Request $request)
    {
        $customer = Customer::create([
            'name' =>$request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        
        Alert::success('Nice!', 'Customer Added!');
        return redirect()->route('customer.index');
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('customer.edit', [
            'customer' => $customer
        ]);
    }

    public function edit_post(Request $request)
    {
        $customer = customer::find($request->id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();

        Alert::success('Well done!', 'Customer Updated!');

        return redirect()->route('customer.index');
    }

    public function delete($id){
        // $users = User::user('writer')->get();
        $customer = Customer::find($id)->delete();
        Alert::success('Oke!', 'Customer Deleted!');

        return redirect()->route('customer.index');
    }
}
