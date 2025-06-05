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

    public function search(Request $request)
    {
        $term = $request->input('term');

        $results = Product::with('productprices.productunit')
                    ->where('name', 'LIKE', '%' . $term . '%')
                    ->orWhere('code','LIKE','%'.$term.'%')
                    ->get();

        return response()->json($results);
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

    private function handle_upload(Request $request,Product $product){
        
        $filename = null;
        try {
            if ($request->hasFile('image')) {
                // Get the file from the request
                $file = $request->file('image');
    
                // Generate a unique name for the file before saving it
                $filename = time() . '_' . $file->getClientOriginalName();
    
                // Save the file in the 'uploads/logos' directory
                $file->storeAs('uploads/products/images', $filename, 'public');
    
                // If updating, delete the old logo if it exists
                if ($product->image && \Storage::disk('public')->exists('uploads/products/images/' . $product->image)) {
                    \Storage::disk('public')->delete('uploads/products/images/' . $product->image);
                }
    
                // Update the logo field with the new filename
            
            }
            $product->image = $filename;
            $product->save();
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function create_post(Request $request)
    {
        $validatedData = $request->validate([
            // 'code' => 'bail|required|unique:products',
            'name' => 'bail|required',
            'category_id' => 'bail|required',
            'unit_id' => 'bail|required',
            'sell_price' => 'bail|required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ensure the file is an image
        ]);

        

        $product = Product::create([
            // 'code' =>$request->code,
            'name' =>$request->name,
            'category_id' =>$request->category_id,
            'description' =>$request->description,
            'stock' =>0
        ]);

        $this->handle_upload($request,$product);

        

        // add price and unit
        $productPrice = ProductPrice::create([
            'product_id' =>$product->id,
            'unit_id' =>$request->unit_id,
            'unit_conversion_value' =>1,
            'buy_price' =>$request->buy_price,
            'sell_price' =>$request->sell_price,
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
        $product = Product::with('defaultProductPrice')->find($id);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Ensure the file is an image
        ]);

        $product = Product::find($request->id);
        $product->code = $request->code;
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->save();

        $this->handle_upload($request,$product);

        Alert::success('Well done!', 'Product  Updated!');

        return redirect()->route('product.index');
    }

    public function delete($id){
        
        $product = Product::find($id)->delete();
        Alert::success('Oke!', 'Product Deleted!');

        return redirect()->route('product.index');
    }
}
