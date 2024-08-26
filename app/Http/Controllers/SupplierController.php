<?php

namespace App\Http\Controllers;

 
use App\DataTables\SupplierDataTable;
use App\DataTables\SalesDataTable;
use App\Models\Supplier;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
Use Alert;
 
class SupplierController extends Controller
{
    public function index(SupplierDataTable $dataTable)
    {
        $title = 'Delete Supplier!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        
        return $dataTable->render('supplier.index');
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function create_post(Request $request)
    {
        $supplier = Supplier::create([
            'name' =>$request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
        ]);
        
        Alert::success('Nice!', 'Supplier Added!');
        return redirect()->route('supplier.index');
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('supplier.edit', [
            'supplier' => $supplier
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->input('term');

        $results = Supplier::where('name', 'LIKE', '%' . $term . '%')
                    // ->orWhere('code','LIKE','%'.$term.'%')
                    ->get();

        return response()->json($results);
    }

    public function detail($id, SalesDataTable $dataTable)
    {

        $title = 'Delete Sales!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        
        $supplier = Supplier::find($id);
        return $dataTable->with('supplier_id', $id)->render('supplier.detail',[
            'supplier' => $supplier
        ]);
    }

    public function edit_post(Request $request)
    {
        $supplier = Supplier::find($request->id);
        $supplier->name = $request->name;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->description = $request->description;
        $supplier->save();

        Alert::success('Well done!', 'Supplier Updated!');

        return redirect()->route('supplier.index');
    }

    public function delete($id){
        // $users = User::user('writer')->get();
        $supplier = Supplier::find($id)->delete();
        Alert::success('Oke!', 'Supplier Deleted!');

        return redirect()->route('supplier.index');
    }
}
