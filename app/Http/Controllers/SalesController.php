<?php

namespace App\Http\Controllers;

 
use App\DataTables\SalesDataTable;
use App\Models\Sales;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
Use Alert;
 
class SalesController extends Controller
{
    public function index(SalesDataTable $dataTable)
    {
        $title = 'Delete Sales!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        
        return $dataTable->render('sales.index');
    }


    public function create_post(Request $request)
    {

        // dd($request->all());
        $sales = Sales::create([
            'supplier_id' => $request->supplier_id,
            'name' =>$request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        
        Alert::success('Nice!', 'Sales Added!');
        return redirect()->route('supplier.detail',[
            'id' => $request->supplier_id
        ]);
    }

    // public function edit($id)
    // {
    //     $sales = Sales::find($id);
    //     return view('sales.edit', [
    //         'sales' => $sales
    //     ]);
    // }

    public function edit_post(Request $request)
    {

        // dd($request->all());
        $sales = Sales::find($request->id);
        $sales->name = $request->name;
        $sales->phone = $request->phone;
        $sales->address = $request->address;
        $sales->save();

        Alert::success('Well done!', 'Sales Updated!');

        return redirect()->route('supplier.detail',[
            'id' => $request->supplier_id
        ]);
    }

    public function delete($id){
        // $users = User::user('writer')->get();
        $sales = Sales::find($id);
        $supplier_id = $sales->supplier_id;
        $sales->delete();
        Alert::success('Oke!', 'Sales Deleted!');

        return redirect()->route('supplier.detail',[
            'id' => $supplier_id
        ]);
    }
}
