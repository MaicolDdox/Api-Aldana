<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shoppingCart = ShoppingCart::with(['book', 'user'])->get();

        return response()->json([
            'data' => $shoppingCart,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar entrada
        $validated = $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,id'],
        ]);

        // Obtener libro
        $book = Book::find($validated['book_id']);

        // Asegurar que el libro exista
        if (!$book) {
            return response()->json([
                'message' => 'El libro no existe.',
            ], 404);
        }

        // Obtener usuario autenticado
        $userId = Auth::id();

        // Crear registro del carrito
        $shoppingCart = ShoppingCart::create([
            'book_id' => $book->id,
            'user_id' => $userId,
            'precio'  => $book->precio,
        ]);

        return response()->json([
            'data' => $shoppingCart,
            'message' => 'Libro agregado al carrito correctamente.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShoppingCart $shoppingCart)
    {
        return response()->json([
            'data' => $shoppingCart->load(['book', 'user']),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        $shoppingCart->delete();

        return response()->json([
            'message' => "Elemento con ID {$shoppingCart->id} eliminado del carrito.",
        ], 200);
    }
}
