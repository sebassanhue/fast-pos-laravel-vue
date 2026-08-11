<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    // Mostrar la pantalla de productos con los datos reales
    public function index()
    {
        // Traemos todos los productos ordenados por el más nuevo
        $products = Product::latest()->get();
        return Inertia::render('Products/Index', [
            'products' => $products
        ]);
    }

    // Guardar un nuevo producto en la base de datos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
        ]);

        Product::create($validated);

        // Recarga la página automáticamente para ver los cambios
        return redirect()->back(); 
    }

    // Eliminar un producto
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back();
    }
}