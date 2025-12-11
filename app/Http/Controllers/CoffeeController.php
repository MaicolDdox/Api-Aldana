<?php

namespace App\Http\Controllers;

use App\Models\Coffee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoffeeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Coffee::query()->where('is_active', true);

        if ($request->filled('brand')) {
            $query->where('brand', $request->query('brand'));
        }

        if ($request->filled('price_order')) {
            $direction = strtolower($request->query('price_order')) === 'desc' ? 'desc' : 'asc';
            $query->orderBy('price', $direction);
        } else {
            $query->latest();
        }

        return response()->json([
            'data' => $query->get(),
        ]);
    }

    public function show(Coffee $coffee): JsonResponse
    {
        if (! $coffee->is_active) {
            return response()->json(['message' => 'Recurso no encontrado'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $coffee]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validatedData($request);
        $coffee = Coffee::create($data);

        return response()->json([
            'message' => 'Café creado',
            'data' => $coffee,
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, Coffee $coffee): JsonResponse
    {
        $data = $this->validatedData($request, true);
        $coffee->update($data);

        return response()->json([
            'message' => 'Café actualizado',
            'data' => $coffee,
        ]);
    }

    public function destroy(Coffee $coffee): JsonResponse
    {
        $coffee->is_active = false;
        $coffee->save();

        return response()->json(['message' => 'Café desactivado']);
    }

    private function validatedData(Request $request, bool $isUpdate = false): array
    {
        $required = $isUpdate ? 'sometimes' : 'required';

        return $request->validate([
            'name' => [$required, 'string', 'max:255'],
            'brand' => [$required, 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => [$required, 'numeric', 'min:0'],
            'stock' => [$required, 'integer', 'min:0'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }
}
