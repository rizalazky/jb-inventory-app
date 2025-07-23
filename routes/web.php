<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPriceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductUnitConversionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('dashboard.index');

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // role
    Route::middleware('role_or_permission:setting-menu role read')->prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::middleware('role_or_permission:setting-menu role create')->get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::middleware('role_or_permission:setting-menu role create')->post('/create', [RoleController::class, 'create_post'])->name('role.create_post');
        Route::middleware('role_or_permission:setting-menu role update')->get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::middleware('role_or_permission:setting-menu role update')->put('/edit/{id}', [RoleController::class, 'edit_post'])->name('role.edit_post');
        Route::middleware('role_or_permission:setting-menu role update')->put('/permission', [RoleController::class, 'permission'])->name('role.permission');
        Route::middleware('role_or_permission:setting-menu role delete')->delete('/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
    });
    // user
    Route::middleware('role_or_permission:setting-menu user read')->prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::middleware('role_or_permission:setting-menu user create')->get('/create', [UserController::class, 'create'])->name('user.create');
        Route::middleware('role_or_permission:setting-menu user create')->post('/create', [UserController::class, 'create_post'])->name('user.create_post');
        Route::middleware('role_or_permission:setting-menu user update')->get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::middleware('role_or_permission:setting-menu user update')->put('/edit/{id}', [UserController::class, 'edit_post'])->name('user.edit_post');
        Route::middleware('role_or_permission:setting-menu user delete')->delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    });
    // customers
    Route::prefix('customer')->group(function () {
        Route::middleware('role_or_permission:customer-menu customer read')->get('/', [CustomerController::class, 'index'])->name('customer.index');
        Route::middleware('role_or_permission:customer-menu customer create')
                ->get('/create', [CustomerController::class, 'create'])
                ->name('customer.create');
        Route::middleware('role_or_permission:customer-menu customer create')
                ->post('/create', [CustomerController::class, 'create_post'])
                ->name('customer.create_post');
        Route::middleware('role_or_permission:customer-menu customer update')
                ->get('/edit/{id}', [CustomerController::class, 'edit'])
                ->name('customer.edit');
        Route::middleware('role_or_permission:customer-menu customer update')
                ->put('/edit/{id}', [CustomerController::class, 'edit_post'])
                ->name('customer.edit_post');
        Route::get('/search', [CustomerController::class, 'search'])
                ->name('customer.search');
        Route::middleware('role_or_permission:customer-menu customer delete')
                ->delete('/delete/{id}', [CustomerController::class, 'delete'])
                ->name('customer.delete');
    });
    // supplier
    Route::prefix('supplier')->group(function () {
        Route::middleware('role_or_permission:supplier-menu supplier read')->get('/', [SupplierController::class, 'index'])->name('supplier.index');
        Route::middleware('role_or_permission:supplier-menu supplier create')
                ->get('/create', [SupplierController::class, 'create'])
                ->name('supplier.create');
        Route::middleware('role_or_permission:supplier-menu supplier create')
                ->post('/create', [SupplierController::class, 'create_post'])
                ->name('supplier.create_post');
        Route::middleware('role_or_permission:supplier-menu supplier update')
                ->get('/edit/{id}', [SupplierController::class, 'edit'])
                ->name('supplier.edit');
        Route::middleware('role_or_permission:supplier-menu supplier update')
                ->put('/edit/{id}', [SupplierController::class, 'edit_post'])
                ->name('supplier.edit_post');
        Route::middleware('role_or_permission:supplier-menu supplier update')
                ->get('/detail/{id}', [SupplierController::class, 'detail'])
                ->name('supplier.detail');
        Route::middleware('role_or_permission:supplier-menu supplier delete')
                ->delete('/delete/{id}', [SupplierController::class, 'delete'])
                ->name('supplier.delete');
        Route::get('/search', [SupplierController::class, 'search'])->name('supplier.search');
    });
    // supplier's sales
    Route::middleware('role_or_permission:lihat sales')->prefix('sales')->group(function () {
        Route::post('/create', [SalesController::class, 'create_post'])->name('sales.create_post');
        // Route::get('/edit/{id}', [SalesController::class, 'edit'])->name('sales.edit');
        Route::post('/edit_post', [SalesController::class, 'edit_post'])->name('sales.edit_post');
        Route::delete('/delete/{id}', [SalesController::class, 'delete'])->name('sales.delete');
    });

    // product categories
    Route::middleware('role_or_permission:master-menu product-category read')->prefix('kategori-produk')->group(function () {
        Route::get('/', [CategoryProductController::class, 'index'])->name('categoryproduct.index');
        Route::middleware('role_or_permission:master-menu product-category create')
                ->get('/create', [CategoryProductController::class, 'create'])
                ->name('categoryproduct.create');
        Route::middleware('role_or_permission:master-menu product-category create')
                ->post('/create', [CategoryProductController::class, 'create_post'])
                ->name('categoryproduct.create_post');
        Route::middleware('role_or_permission:master-menu product-category update')
                ->get('/edit/{id}', [CategoryProductController::class, 'edit'])
                ->name('categoryproduct.edit');
        Route::middleware('role_or_permission:master-menu product-category update')
                ->put('/edit/{id}', [CategoryProductController::class, 'edit_post'])
                ->name('categoryproduct.edit_post');
        Route::middleware('role_or_permission:master-menu product-category delete')
                ->delete('/delete/{id}', [CategoryProductController::class, 'delete'])
                ->name('categoryproduct.delete');
    });

    // product unit
    Route::middleware('role_or_permission:master-menu product-unit read')->prefix('unit-produk')->group(function () {
        Route::get('/', [ProductUnitController::class, 'index'])
                ->name('productunit.index');
        Route::middleware('role_or_permission:master-menu product-unit create')
                ->get('/create', [ProductUnitController::class, 'create'])
                ->name('productunit.create');
        Route::middleware('role_or_permission:master-menu product-unit create')
                ->post('/create', [ProductUnitController::class, 'create_post'])
                ->name('productunit.create_post');
        Route::middleware('role_or_permission:master-menu product-unit update')
                ->get('/edit/{id}', [ProductUnitController::class, 'edit'])
                ->name('productunit.edit');
        Route::middleware('role_or_permission:master-menu product-unit update')
                ->put('/edit/{id}', [ProductUnitController::class, 'edit_post'])
                ->name('productunit.edit_post');
        Route::middleware('role_or_permission:master-menu product-unit delete')
                ->delete('/delete/{id}', [ProductUnitController::class, 'delete'])
                ->name('productunit.delete');
    });

    // product
    Route::middleware('role_or_permission:master-menu product read')->prefix('produk')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::middleware('role_or_permission:master-menu product create')
                ->get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::middleware('role_or_permission:master-menu product create')
                ->post('/create', [ProductController::class, 'create_post'])->name('product.create_post');
        Route::middleware('role_or_permission:master-menu product update')
                ->get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::middleware('role_or_permission:master-menu product update')
                ->put('/edit/{id}', [ProductController::class, 'edit_post'])->name('product.edit_post');
        Route::middleware('role_or_permission:master-menu product delete')
                ->delete('/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
        Route::get('/search', [ProductController::class, 'search'])->name('product.search');
    });

    // product price
    Route::middleware('role_or_permission:master-menu product read')->prefix('harga-produk')->group(function () {
        Route::get('/', [ProductPriceController::class, 'index'])->name('productprice.index');
        Route::post('/', [ProductPriceController::class, 'create_post'])->name('productprice.create_post');
        Route::post('/set-default', [ProductPriceController::class, 'set_default_price'])->name('productprice.set_default_price');
        Route::post('/set-default-display', [ProductPriceController::class, 'set_default_price_diplay'])->name('productprice.set_default_price_display');
        Route::post('/update', [ProductPriceController::class, 'edit_post'])->name('productprice.edit_post');
        // Route::put('/{id}', [ProductPriceController::class, 'edit_post'])->name('productprice.edit_post');
        Route::get('/delete/{id}', [ProductPriceController::class, 'delete'])->name('productprice.delete');
    });

    // unit conversions
    Route::middleware('role_or_permission:master-menu product read')->prefix('konversi-satuan')->group(function () {
        Route::get('/', [ProductUnitConversionController::class, 'index'])->name('unitconversions.index');
        Route::post('/', [ProductUnitConversionController::class, 'create_post'])->name('unitconversions.create_post');
        Route::post('/set-default', [ProductUnitConversionController::class, 'set_default_price'])->name('unitconversions.set_default_price');
        Route::post('/update', [ProductUnitConversionController::class, 'edit_post'])->name('unitconversions.edit_post');
        // Route::put('/{id}', [ProductUnitConversionController::class, 'edit_post'])->name('unitconversions.edit_post');
        Route::get('/delete/{id}', [ProductUnitConversionController::class, 'delete'])->name('unitconversions.delete');
    });

    Route::middleware('role_or_permission:stock-menu')->prefix('stok')->group(function () {
        Route::post('/', [StockController::class, 'store'])->name('stock.store');
        Route::middleware('role_or_permission:stock-menu stock-in create')->get('/in', [StockController::class, 'in'])->name('stock.in');
        Route::middleware('role_or_permission:stock-menu stock-out create')->get('/out', [StockController::class, 'out'])->name('stock.out');
        Route::get('/edit/{id}', [StockController::class, 'edit'])->name('stock.edit');
        Route::put('/edit/{id}', [StockController::class, 'editput'])->name('stock.editput');
        Route::get('/history', [StockController::class, 'history'])->name('stock.index');
        Route::delete('/delete/{id}', [StockController::class, 'delete'])->name('stock.delete');
    });

    Route::middleware('role_or_permission:transaction-menu')->prefix('transaksi')->group(function () {
        Route::middleware('role_or_permission:transaction-menu transaction-in read|transaction-menu transaction-out read')
                ->get('/detail/{id}', [TransactionController::class, 'detail'])->name('transaction.detail');
        Route::middleware('role_or_permission:transaction-menu transaction-in create')
                ->get('/pembelian', [TransactionController::class, 'in'])->name('transaction.in');
        Route::post('/save', [TransactionController::class, 'store'])->name('transaction.store');
        Route::middleware('role_or_permission:transaction-menu transaction-out create')
                ->get('/penjualan', [TransactionController::class, 'out'])->name('transaction.out');
        Route::middleware('role_or_permission:transaction-menu transaction-in update|transaction-menu transaction-out update')
                ->get('/edit/{id}', [TransactionController::class, 'edit'])->name('transaction.edit');
        Route::middleware('role_or_permission:transaction-menu transaction-in update|transaction-menu transaction-out update')
                ->put('/edit/{id}', [TransactionController::class, 'update'])->name('transaction.editput');
        Route::middleware('role_or_permission:transaction-menu transaction-in read|transaction-menu transaction-out read')
                ->get('/history', [TransactionController::class, 'history'])->name('transaction.index');
        Route::middleware('role_or_permission:transaction-menu transaction-in delete|transaction-menu transaction-out delete')
                ->delete('/delete/{id}', [TransactionController::class, 'delete'])->name('transaction.delete');
        Route::get('/pdf/preview/{id}', [PdfController::class, 'previewPdf']);
        Route::post('/findproduct', [TransactionController::class, 'find_product'])->name('transaction.find_product');
    });

    Route::middleware('role_or_permission:report-menu')->prefix('laporan')->group(function () {
        Route::get('/penjualan', [ReportController::class, 'penjualan'])->name('laporan.penjualan');
        Route::middleware('role_or_permission:report-menu report create')
                ->post('/transaksi/pdf', [ReportController::class, 'generate_pdf'])
                ->name('report.generatepdf');
        Route::get('/pembelian', [ReportController::class, 'pembelian'])->name('laporan.pembelian');
        // Route::get('/stok', [ReportController::class, 'stok'])->name('laporan.stok');
    });
    

    Route::middleware('role_or_permission:setting-menu access read')->get('/akses',[PermissionController::class,'index'])->name('akses.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role_or_permission:setting-menu config read')->get('/config', [ConfigController::class, 'view'])->name('config.index');
    Route::middleware('role_or_permission:setting-menu config update|setting-menu config create')->post('/config', [ConfigController::class, 'store'])->name('config.store');
    // Route::delete('/config', [ConfigController::class, 'destroy'])->name('config.destroy');
});

require __DIR__.'/auth.php';
