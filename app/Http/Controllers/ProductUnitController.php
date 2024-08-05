<?php

namespace App\Http\Controllers;

 
use App\DataTables\ProductUnitDataTable;
use App\Models\ProductUnit;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use Alert;
 
class ProductUnitController extends Controller
{
    public function index(ProductUnitDataTable $dataTable)
    {
        $title = 'Delete Product Unit!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        
        return $dataTable->render('productunit.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('productunit.create', [
            'roles' => $roles
        ]);
    }

    public function create_post(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'bail|required|unique:product_unit'
        ]);

       

        $productunit = ProductUnit::create([
            'name' =>$request->name,
        ]);

    
        Alert::success('Nice!', 'Product Unit Added!');
        return redirect()->route('productunit.index');
    }

    public function edit($id)
    {
        $productunit = ProductUnit::find($id);
        
        return view('productunit.edit', [
            'productunit' => $productunit,
        ]);
    }

    public function edit_post(Request $request)
    {
        $productunit = ProductUnit::find($request->id);
        $productunit->name = $request->name;
        $productunit->save();

        Alert::success('Well done!', 'Product Unit Updated!');

        return redirect()->route('productunit.index');
    }

    public function delete($id){
        
        $productunit = ProductUnit::find($id)->delete();
        Alert::success('Oke!', 'Product Unit Deleted!');

        return redirect()->route('productunit.index');
    }
}
