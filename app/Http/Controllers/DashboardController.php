<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;

class DashboardController extends Controller
{
    //
    public function index(){
        $products = Product::count();
        $customers = Customer::count();
        $suppliers = Supplier::count();
        return view('dashboard',[
            'products' =>$products,
            'customers' =>$customers,
            'suppliers' =>$suppliers,
        ]);
    }
}
