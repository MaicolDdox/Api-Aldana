<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Crear una factura sumando el total de los ítems del carrito.
     *
     * 1. Valida que el carrito exista.
     * 2. Obtiene todos los registros del carrito.
     * 3. Suma los precios de cada registro.
     * 4. Genera una factura en la tabla bills.
     * 5. Retorna la factura creada con el total calculado.
     */
    public function store(Request $request)
    {
        // Validación de entrada
        $validated = $request->validate([
            'shoppingCart_id' => ['required', 'integer', 'exists:shopping_carts,id'],
        ]);

        // Obtener el carrito solicitado
        $shoppingCartId = $validated['shoppingCart_id'];

        // Obtener todos los registros pertenecientes a este carrito
        $shoppingCartItems = ShoppingCart::where('id', $shoppingCartId)->get();

        // Si el carrito está vacío
        if ($shoppingCartItems->isEmpty()) {
            return response()->json([
                'message' => 'El carrito no contiene productos.',
            ], 400);
        }

        // Calcular el total sumando el precio de cada ítem del carrito
        $totalFactura = $shoppingCartItems->sum('precio');

        // Crear la factura
        $bill = Bill::create([
            'shoppingCart_id' => $shoppingCartId,
            'total' => $totalFactura,
        ]);

        return response()->json([
            'data' => $bill,
            'message' => 'Factura generada correctamente.',
        ], 201);
    }


    /**
     * Mostrar una factura específica.
     * Retorna la factura junto con su carrito asociado.
     */
    public function show(Bill $bill)
    {
        return response()->json([
            'data' => $bill->load('shoppingCart'),
        ], 200);
    }

    /**
     * Eliminar una factura.
     */
    public function destroy(Bill $bill)
    {
        $bill->delete();

        return response()->json([
            'message' => "Factura con ID {$bill->id} eliminada correctamente.",
        ], 200);
    }
}
