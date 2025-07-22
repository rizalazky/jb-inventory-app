<?php

namespace App\Http\Controllers;

 
use App\DataTables\StockDataTable;
use App\Models\Stock;
use App\Models\Product;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use Alert;

 
class StockController extends Controller
{
    public function history(StockDataTable $dataTable){
        $title = 'Hapus Data Stok!';
        $text = "Yakin hapus data?";
        confirmDelete($title, $text);

        
        return $dataTable->render('stock.index');
    }


    public function store(Request $request){
        $validatedData = $request->validate([
            'type' => 'required',
            'product_id' => 'bail|required',
            'product_price_id' => 'bail|required',
            'quantity' => 'bail|required',
        ]);

        Stock::create([
            'type' => $request->type,
            'product_id' => $request->product_id,
            'product_price_id' => $request->product_price_id,
            'quantity' => $request->quantity,
            'base_quantity' => $request->base_quantity,
            'notes' => $request->notes,
            'user_by' => Auth::id(),
        ]);

        Alert::success('Nice!', 'Stock  Added!');
        return redirect()->route('product.index');

        
    }

    public function in(){
        return view('stock.create',['type'=>'in']);
    }
    
    public function out(){
        return view('stock.create',['type'=>'out']);
    }

    public function edit($id){
        $data = Stock::with('transaction')->find($id);
        return view('stock.edit',['data'=>$data]);
    }

    public function editput(Request $request)
    {
        
        $data = Stock::find($request->id);
        $data->product_price_id = $request->product_price_id;
        $data->quantity = $request->quantity;
        $data->base_quantity = $request->base_quantity;
        $data->notes = $request->notes;
        $data->save();

        Alert::success('Well done!', 'Role Updated!');

        return redirect()->route('stock.index');
    }

    public function delete($id){
        // $users = User::user('writer')->get();
        $supplier = Stock::find($id)->delete();
        Alert::success('Oke!', 'Data berhasil dihapus!');

        return redirect()->route('stock.index');
    }
}