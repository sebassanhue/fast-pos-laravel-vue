<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Models\Product;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Pos/Index', ['products' => Product::all()]);
});

// Inventario
Route::get('/productos', [ProductController::class, 'index']);
Route::post('/productos', [ProductController::class, 'store']);
Route::delete('/productos/{product}', [ProductController::class, 'destroy']);

// Ventas e Historial
Route::post('/ventas', [SaleController::class, 'store']);
Route::get('/historial', [SaleController::class, 'history']);

require __DIR__.'/auth.php';