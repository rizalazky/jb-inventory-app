<?php

namespace App\Http\Controllers;

 
use App\DataTables\ProductDataTable;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use App\Models\Stock;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
Use Alert;
 
class ProductController extends Controller
{
    public function index(ProductDataTable $dataTable)
    {
        $title = 'Delete Product !';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        
        return $dataTable->render('product.index');
    }

    public function create()
    {
        $categories = ProductCategory::all();
        $units = ProductUnit::all();
        return view('product.create', [
            'categories' => $categories,
            'units' => $units,
        ]);
    }

    public function create_post(Request $request)
    {
        $validatedData = $request->validate([
            // 'code' => 'bail|required|unique:products',
            'name' => 'bail|required',
            'category_id' => 'bail|required',
            'unit_id' => 'bail|required',
            'price' => 'bail|required',
        ]);

        $product = Product::create([
            // 'code' =>$request->code,
            'name' =>$request->name,
            'category_id' =>$request->category_id,
            'description' =>$request->description,
            'stock' =>0
        ]);

        

        // add price and unit
        $productPrice = ProductPrice::create([
            'product_id' =>$product->id,
            'unit_id' =>$request->unit_id,
            'price' =>$request->price,
            'is_default'=>true
        ]);

        // add initial stock
        $stock = Stock::create([
            'type' => "in",
            'product_id' => $product->id,
            'product_price_id' => $productPrice->id,
            'quantity' => $request->stock,
            'notes' => "Initial Stock",
            'user_by' => Auth::id(),
        ]);
    
        Alert::success('Nice!', 'Product  Added!');
        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $product_units = ProductUnit::all();
        $categories = ProductCategory::all();
        
        return view('product.edit', [
            'product' => $product,
            'categories' => $categories,
            'product_units' => $product_units,
        ]);
    }


    public function edit_post(Request $request)
    {
        $validatedData = $request->validate([
            'code' => [
                'bail',
                'required',
                Rule::unique('products')->ignore($request->id)
            ],
            'name' => 'bail|required',
            'category_id' => 'bail|required',
        ]);

        $product = Product::find($request->id);
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->save();

        Alert::success('Well done!', 'Product  Updated!');

        return redirect()->route('product.index');
    }

    public function delete($id){
        
        $product = Product::find($id)->delete();
        Alert::success('Oke!', 'Product Deleted!');

        return redirect()->route('product.index');
    }
}
