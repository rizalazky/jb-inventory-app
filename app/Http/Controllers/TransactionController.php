<?php

namespace App\Http\Controllers;

 
use App\DataTables\TransactionDataTable;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
Use Alert;

 
class TransactionController extends Controller
{
    public function history(TransactionDataTable $dataTable){
        $title = 'Hapus Transaksi!';
        $text = "Yakin hapus data?";
        confirmDelete($title, $text);

        
        return $dataTable->render('transaction.index');
    }


    public function store(Request $request){
        $validatedData = $request->validate([
            'type' => 'required',
            'date' => 'bail|required',
            // 'transaction_number' => 'bail|required',
            'sub_total' => 'bail|required',
            'discount' => 'bail|required',
            'total' => 'bail|required',
        ]);

        // return response()->json([
        //     'status' => 'OK',
        //     'message' => 'Oke'
        // ]);

        DB::beginTransaction();

        try {
            $transaction = new Transaction([
                'type' => $request->type,
                'date' => $request->date,
                'customer_id' => $request->customer_id,
                'supplier_id' => $request->supplier_id,
                'transaction_number' => $request->transaction_number,
                'sub_total' => $request->sub_total,
                'discount' => $request->discount,
                'total' => $request->total,
                'user_by' => Auth::id(),
            ]);
            
            $transaction->save();
            
            foreach ($request->items as $item) {
                $transactionDetail = new TransactionDetail([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'],
                    'product_price_id' => $item['product_price_id'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'discount' => $item['discount'],
                ]);
                $transactionDetail->save();
            }
    
            // Step 3: Commit the transaction
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully!',
                'transaction' => $transaction,
                'transaction_details' => $transaction->transactionDetails // Assuming a one-to-many relationship
            ], 201);

        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error creating transaction: ' . $e->getMessage()
            ], 500);
        }
    }

    public function in(){
        return view('transaction.create',['type'=>'in']);
    }
    
    public function out(){
        return view('transaction.create',['type'=>'out']);
    }

    public function edit($id){
        $data = Transaction::with(['transaction_details.product.productprices.productunit','supplier'])->find($id);
        return view('transaction.edit',['data'=>$data]);
    }

    public function editput(Request $request)
    {
        
        $data = Transaction::find($request->id);
        $data->product_price_id = $request->product_price_id;
        $data->quantity = $request->quantity;
        $data->notes = $request->notes;
        $data->save();

        Alert::success('Well done!', 'Role Updated!');

        return redirect()->route('stock.index');
    }

    public function delete($id){
        // $users = User::user('writer')->get();
        $supplier = Transaction::find($id)->delete();
        Alert::success('Oke!', 'Data berhasil dihapus!');

        return redirect()->route('transaction.index');
    }
}