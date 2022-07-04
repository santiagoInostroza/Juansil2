<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\ProductController::class,'catalog'])->name('products.catalog');
Route::get('/', [App\Http\Controllers\ProductController::class,'catalog'])->name('home.index');
Route::get('/productospormayor', [App\Http\Controllers\ProductController::class,'wholesale'])->name('products.wholesale.index');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/admin', [AdminController::class,'index'])->name('admin.index');

    Route::resource('roles', RoleController::class)->names('admin.roles');

    Route::resource('permisos', PermissionController::class)->names('admin.permissions')->parameters([
        'permisos' => 'permission'
    ]);;

    Route::resource('categorias', CategoryController::class)->names('admin.categories')->parameters([
        'categorias' => 'category:slug'
    ]);

    Route::resource('marcas', BrandController::class)->names('admin.brands')->parameters([
        'marcas' => 'brand:slug'
    ]);

    Route::get('productos/movimientos', [App\Http\Controllers\Admin\ProductController::class,'movements'])->name('admin.products.movements');
    Route::get('productos/detalle', [App\Http\Controllers\Admin\ProductController::class,'details'])->name('admin.products.details');
    Route::resource('productos', App\Http\Controllers\Admin\ProductController::class)->names('admin.products')->parameters([
        'productos' => 'product:slug'
    ]);

    Route::resource('proveedores', SupplierController::class)->names('admin.suppliers')->parameters([
        'proveedores' => 'supplier:slug'
    ]);

    Route::get('compras/detalle', [PurchaseController::class,'details'])->name('admin.purchases.details');
    Route::resource('compras', PurchaseController::class)->names('admin.purchases')->parameters([
        'compras' => 'purchase'
    ]);

    Route::resource('direcciones', AddressController::class)->names('admin.addresses')->parameters([
        'direcciones' => 'address:slug'
    ]);

    Route::resource('clientes', CustomerController::class)->names('admin.customers')->parameters([
        'clientes' => 'customer:slug'
    ]);

    Route::resource('pedidos', OrderController::class)->names('admin.orders')->parameters([
        'pedidos' => 'order'
    ]);
    
});
