<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class CategoryWebController extends Controller
{
    public function index(Request $request)
    {
        // 2.2 Listado + 2.3 Buscador simple

        $search = $request->input('search');

        $query = Category::query()
            ->withCount('cars'); // 7. cantidad de carros por categoría

        // 🔍 Filtro por nombre
        // Filtrado en backend usando WHERE ILIKE en PostgreSQL
        if ($search) {
            $query->where('name', 'ILIKE', "%{$search}%");
        }

        $categories = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();

        return Inertia::render('Categories/Index', [
            'categories' => $categories,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function create()
    {
         return Inertia::render('Categories/Create');
    }

public function store(Request $request)
{
    // 3.2.3.2 - Validación en backend
    $validated = $request->validate([
        'name'        => 'required|string|min:3|max:100',
        'description' => 'nullable|string|max:255',
        'priority'    => 'required|integer|min:1',
        'state'       => 'required|boolean',
    ], [
        // Mensajes personalizados (opcional pero recomendado)
        'name.required' => 'El nombre es obligatorio.',
        'name.min' => 'El nombre debe tener al menos 3 caracteres.',
        'name.max' => 'El nombre no puede superar los 100 caracteres.',
        'priority.required' => 'La prioridad es obligatoria.',
        'priority.min' => 'La prioridad debe ser al menos 1.',
        'state.required' => 'El estado es obligatorio.',
    ]);

    Category::create($validated);

    // 3.2.3.1 - Mensaje de éxito
    return redirect()
        ->route('categories.index')
        ->with('success', 'Categoría creada correctamente.');
}

    public function show(Category $category)
    {
        $category->load('cars'); // 5.2 usar load/with

        return Inertia::render('Categories/Show', [
            'category' => $category,
        ]);
    }

    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'description' => 'nullable|string|max:255',
            'priority' => 'required|integer|min:1',
            'state' => 'required|boolean',
        ]);

        $category->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->back()
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
