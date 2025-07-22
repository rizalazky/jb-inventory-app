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
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
Use Alert;

 
class ReportController extends Controller
{
    public function find_product(Request $request){
        $data = "OKE";
        return response()->json([
            'success' => true,
            'message' => 'Product Found!',
            'data' => $data
        ], 201);
    }


    public function penjualan(TransactionDataTable $dataTable){
        return view('report.index',['type'=>'penjualan']);
    }
    public function pembelian(TransactionDataTable $dataTable){
        return view('report.index',['type'=>'pembelian']);
    }

    public function generate_pdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $type = $request->input('type');

        $transactions = Transaction::where('type', $type)
                ->whereBetween('date', [$startDate, $endDate])
                ->get();

    
        // Fetch the transaction and related data
        // $transaction = Transaction::where('transaction_details.product', 'customer')->findOrFail($id);
        $setting = Setting::first();

        // Prepare the data for the receipt
        $data = [
            'transactions' => $transactions,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'type' => $type,
            'setting'=>$setting
        ];

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('pdf.laporantransaksi', $data);

        // $pdf->setPaper([0, 0, 226.77, 651.18]); // Custom paper size in points (width: 80mm, height: 230mm approx)
        
        return $pdf->stream('receipt.pdf');
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

    public function delete($id){
        // $users = User::user('writer')->get();
        $supplier = Transaction::find($id)->delete();
        Alert::success('Oke!', 'Data berhasil dihapus!');

        return redirect()->route('transaction.index');
    }
}