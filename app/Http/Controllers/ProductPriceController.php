<?php

namespace App\Http\Controllers;

 
use App\DataTables\ProductDataTable;
use App\Models\ProductPrice;
use App\Models\ProductUnit;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use Alert;
 
class ProductPriceController extends Controller
{
    public function create_post(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'unit_id' => 'required',
            'price' => 'required',
        ]);

        $product = ProductPrice::create([
            'product_id' =>$request->product_id,
            'unit_id' =>$request->unit_id,
            'price' =>$request->price
        ]);

    
        Alert::success('Sipp!', 'Harga Produk berhasil ditambahkan!');
        return redirect()->route('product.edit',['id' => $request->product_id]);
    }


    public function edit_post(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'unit_id' => 'required',
            'price' => 'required',
        ]);

        $product = ProductPrice::find($request->id);
        $product->product_id = $request->product_id;
        $product->unit_id = $request->unit_id;
        $product->price = $request->price;
        $product->save();

        Alert::success('OKE!', 'Berhasil update harga produk!');

        return redirect()->route('product.edit',['id' => $request->product_id]);
    }

    public function set_default_price(Request $request){
        $product_prices = ProductPrice::where('product_id', $request->product_id)->where('id','<>',$request->id)->update(['is_default' => false]);

        $product_price = ProductPrice::find($request->id);
        $product_price->is_default = !$product_price->is_default;
        $product_price->save();

        Alert::success('Well done!', 'Berhasil atur harga default!');

        return redirect()->route('product.edit',['id' => $request->product_id]);
    }

    public function delete($id){
        
        $product_price = ProductPrice::find($id);
        $product_id = $product_price->product->id;
        $product_price->delete();
        Alert::success('Oke!', 'Berhasil menghapus harga produk!');

        return redirect()->route('product.edit',['id' => $product_id]);
    }
}
