<?php

namespace App\Http\Controllers;

 
use App\DataTables\CategoryProductDataTable;
use App\Models\ProductCategory;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
Use Alert;
 
class CategoryProductController extends Controller
{
    public function index(CategoryProductDataTable $dataTable)
    {
        $title = 'Delete Product Category!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        
        return $dataTable->render('categoryproduct.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('categoryproduct.create', [
            'roles' => $roles
        ]);
    }

    public function create_post(Request $request)
    {
        $categoryproduct = ProductCategory::create([
            'name' =>$request->name,
        ]);

    
        Alert::success('Nice!', 'Product Category Added!');
        return redirect()->route('categoryproduct.index');
    }

    public function edit($id)
    {
        $categoryproduct = ProductCategory::find($id);
        
        return view('categoryproduct.edit', [
            'categoryproduct' => $categoryproduct,
        ]);
    }

    public function edit_post(Request $request)
    {
        $categoryproduct = ProductCategory::find($request->id);
        $categoryproduct->name = $request->name;
        $categoryproduct->save();

        Alert::success('Well done!', 'Product Category Updated!');

        return redirect()->route('categoryproduct.index');
    }

    public function delete($id){
        
        $categoryproduct = ProductCategory::find($id)->delete();
        Alert::success('Oke!', 'Product Category Deleted!');

        return redirect()->route('categoryproduct.index');
    }
}
