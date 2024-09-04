<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function previewPdf($id)
    {
        // Fetch the transaction and related data
        $transaction = Transaction::with('transaction_details.product', 'customer')->findOrFail($id);

        // Prepare the data for the receipt
        $receiptData = [
            'transaction' => $transaction,
            'details' => $transaction->transaction_details,
            'customer' => $transaction->customer,
        ];

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('pdf.receipt', ['transaction' => $transaction]);

        $pdf->setPaper([0, 0, 226.77, 651.18]); // Custom paper size in points (width: 80mm, height: 230mm approx)
        // $pdf->render();
        // $pdf = Pdf::loadHTML('Hello');
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->download('invoice.pdf');
        // return $pdf->output();
        return $pdf->stream('receipt.pdf');
        // Return the PDF output to be embedded in the frontend
        // return $pdf->output();
    }
}

