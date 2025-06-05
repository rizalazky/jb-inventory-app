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
            'buy_price' => 'required',
            'sell_price' => 'required',
            'unit_conversion_value' => 'required',
        ]);

        $product = ProductPrice::create([
            'product_id' =>$request->product_id,
            'unit_id' =>$request->unit_id,
            'buy_price' =>$request->buy_price,
            'sell_price' =>$request->sell_price,
            'unit_conversion_value' =>$request->unit_conversion_value,
        ]);

    
        Alert::success('Sipp!', 'Product Price Added!');
        return redirect()->route('product.edit',['id' => $request->product_id]);
    }


    public function edit_post(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'unit_id' => 'required',
            'buy_price' => 'required',
            'sell_price' => 'required',
            'unit_conversion_value' => 'required',
        ]);

        $product = ProductPrice::find($request->id);
        $product->product_id = $request->product_id;
        $product->unit_id = $request->unit_id;
        $product->buy_price = $request->buy_price;
        $product->sell_price = $request->sell_price;
        
            $product->unit_conversion_value = $request->unit_conversion_value;
        
        $product->save();

        Alert::success('OKE!', 'Product Price Updated!');

        return redirect()->route('product.edit',['id' => $request->product_id]);
    }

    public function set_default_price(Request $request){
        $product_prices = ProductPrice::where('product_id', $request->product_id)->where('id','<>',$request->id)->update(['is_default' => false]);

        $product_price = ProductPrice::find($request->id);
        $product_price->is_default = !$product_price->is_default;
        $product_price->save();

        Alert::success('Well done!', 'Default Product Price!');

        return redirect()->route('product.edit',['id' => $request->product_id]);
    }

    public function delete($id){
        
        $product_price = ProductPrice::find($id);
        $product_id = $product_price->product->id;
        $product_price->delete();
        Alert::success('Oke!', 'Product Price Deleted!');

        return redirect()->route('product.edit',['id' => $product_id]);
    }
}
