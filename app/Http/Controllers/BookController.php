<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Listar todos los libros.
     */
    public function index()
    {
        // Obtenemos todos los libros
        $books = Book::all();

        // Opcionalmente, podrías mapear aquí la URL completa de la imagen
        // pero por simplicidad devolvemos el path relativo almacenado en "foto".
        return response()->json($books, 200);
    }

    /**
     * Crear un nuevo libro en almacenamiento.
     * Ahora admite subida de imagen para el campo "foto".
     */
    public function store(Request $request)
    {
        // Validación de datos de texto y campos numéricos
        $validated = $request->validate([
            'category_id'        => ['required', 'exists:categories,id'],
            'titulo'             => ['required', 'string', 'max:30'],
            'descripccion_larga' => ['required', 'string', 'max:65535'],
            'autor'              => ['required', 'string', 'max:50'],
            'editorial'          => ['required', 'string', 'max:50'],
            'year'               => ['required', 'string', 'max:4'],
            'numero_paginas'     => ['required', 'string', 'max:255'],
            'stock'              => ['required', 'integer'],
            'precio'             => ['required', 'integer'],
            'estado'             => ['required', Rule::in(['disponible', 'agotado'])],

            // Validación de la imagen (ahora es archivo, no string)
            'foto'               => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp'],
        ]);

        // Si se envió una imagen, la guardamos en storage/app/public/books
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('books', 'public');
            $validated['foto'] = $path; // guardamos el path relativo en la columna "foto"
        }

        // Creamos el libro con los datos validados (incluyendo el path de la imagen si existe)
        $book = Book::create($validated);

        return response()->json([
            'data'    => $book,
            'message' => 'Libro agregado correctamente',
        ], 201);
    }

    /**
     * Mostrar un libro específico.
     */
    public function show(Book $book)
    {
        return response()->json([
            'data'    => $book,
            'message' => 'Ok',
        ], 200);
    }

    /**
     * Actualizar un libro existente.
     * También permite actualizar la imagen y sustituir la anterior.
     */
    public function update(Request $request, Book $book)
    {
        // Validación parcial (solo campos enviados)
        $validated = $request->validate([
            'category_id'        => ['sometimes', 'exists:categories,id'],
            'titulo'             => ['sometimes', 'string', 'max:30'],
            'descripccion_larga' => ['sometimes', 'string', 'max:65535'],
            'autor'              => ['sometimes', 'string', 'max:50'],
            'editorial'          => ['sometimes', 'string', 'max:50'],
            'year'               => ['sometimes', 'string', 'max:4'],
            'numero_paginas'     => ['sometimes', 'string', 'max:255'],
            'stock'              => ['sometimes', 'integer'],
            'precio'             => ['sometimes', 'integer'],
            'estado'             => ['sometimes', Rule::in(['disponible', 'agotado'])],

            // Validación de la nueva imagen si viene en la petición
            'foto'               => ['sometimes', 'image', 'mimes:jpeg,jpg,png,gif,webp'],
        ]);

        // Si se envió una nueva imagen, borramos la anterior (si existía)
        if ($request->hasFile('foto')) {
            // Borrar imagen anterior
            if ($book->foto) {
                Storage::disk('public')->delete($book->foto);
            }

            // Guardar nueva imagen
            $path = $request->file('foto')->store('books', 'public');
            $validated['foto'] = $path;
        }

        // Actualizar registro con los datos validados
        $book->update($validated);

        return response()->json([
            'data'    => $book,
            'message' => 'Libro actualizado correctamente',
        ], 200);
    }

    /**
     * Eliminar un libro.
     * También elimina la imagen asociada del storage (si existe).
     */
    public function destroy(Book $book)
    {
        // Si el libro tiene una imagen almacenada, la eliminamos
        if ($book->foto) {
            Storage::disk('public')->delete($book->foto);
        }

        $book->delete();

        return response()->json([
            'data'    => $book,
            'message' => 'Libro con ID ' . $book->id . ' eliminado correctamente',
        ], 200);
    }
}
