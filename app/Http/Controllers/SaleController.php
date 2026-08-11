<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    // Guardar una nueva venta
    public function store(Request $request)
    {
        Sale::create([
            'order_number' => 'ORD-' . rand(1000, 9999), // Genera un código aleatorio
            'total' => $request->total,
            'items' => $request->items,
        ]);

        return redirect()->back();
    }

    // Mostrar el historial de ventas
    public function history()
    {
        $sales = Sale::latest()->get();
        return Inertia::render('History/Index', [
            'sales' => $sales
        ]);
    }
}