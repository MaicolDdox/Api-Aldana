<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shoppingCart = ShoppingCart::all();
        return response()->json($shoppingCart, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'total' => ['required', 'integer'],
        ]);

        $shoppingCart = new ShoppingCart($validated);
        $shoppingCart->save();

        return response()->json([
            'data'    => $shoppingCart,
            'message' => 'Libro agregado al carrito',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingCart $shoppingCart)
    {
        return response()->json($shoppingCart, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        $shoppingCart->delete();

        return response()->json([
            'data'    => $shoppingCart,
            'message' => 'Carrito de Compras con ID ' . $shoppingCart->id . ' eliminado correctamente',
        ], 200);
    }
}
