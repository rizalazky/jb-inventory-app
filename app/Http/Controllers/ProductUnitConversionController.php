<?php

namespace App\Http\Controllers;

 
use App\DataTables\ProductDataTable;
use App\Models\UnitConversion;
use App\Models\ProductUnit;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use Alert;
 
class ProductUnitConversionController extends Controller
{
    public function create_post(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'product_price_id_from' => 'required',
            'product_price_id_to' => 'required',
            'value' => 'required',
        ]);

        $product = UnitConversion::create([
            'product_id' =>$request->product_id,
            'product_price_id_from' =>$request->product_price_id_from,
            'product_price_id_to' =>$request->product_price_id_to,
            'value' =>$request->value
        ]);

    
        Alert::success('Sipp!', 'Konversi berhasil ditambahkan!');
        return redirect()->route('product.edit',['id' => $request->product_id]);
    }


    public function edit_post(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'product_price_id_from' => 'required',
            'product_price_id_to' => 'required',
            'value' => 'required',
        ]);

        $product = UnitConversion::find($request->id);
        $product->product_price_id_from = $request->product_price_id_from;
        $product->product_price_id_to = $request->product_price_id_to;
        $product->value = $request->value;
        $product->save();

        Alert::success('OKE!', 'Berhasil update Konversi!');

        return redirect()->route('product.edit',['id' => $request->product_id]);
    }


    public function delete($id){
        
        $product_price = UnitConversion::find($id);
        $product_id = $product_price->product->id;
        $product_price->delete();
        Alert::success('Oke!', 'Berhasil menghapus Konversi!');

        return redirect()->route('product.edit',['id' => $product_id]);
    }
}
