<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarWebController extends Controller
{
    /**
     * 6. Listado de carros con buscador y paginación
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Car::query()
            ->with('category'); // Cargar relación con categoría

        // Filtrado por marca o modelo
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('car_make', 'ILIKE', "%{$search}%")
                  ->orWhere('car_model', 'ILIKE', "%{$search}%")
                  ->orWhere('barcode', 'ILIKE', "%{$search}%");
            });
        }

        $cars = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return Inertia::render('Cars/Index', [
            'cars' => $cars,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    /**
     * 6. Mostrar formulario de creación
     */
    public function create()
    {
        // Obtener todas las categorías para el select
        $categories = Category::where('state', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Cars/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * 6. Guardar nuevo carro
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'car_make' => 'required|string|min:2|max:100',
            'car_model' => 'required|string|min:2|max:100',
            'car_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'car_price' => 'required|numeric|min:0',
            'car_status' => 'required|boolean',
            'barcode' => 'required|string|unique:cars,barcode|max:50',
            'category_id' => 'required|exists:categories,id',
        ], [
            'car_make.required' => 'La marca es obligatoria.',
            'car_model.required' => 'El modelo es obligatorio.',
            'car_year.required' => 'El año es obligatorio.',
            'car_year.max' => 'El año no puede ser mayor a ' . (date('Y') + 1) . '.',
            'car_price.required' => 'El precio es obligatorio.',
            'car_price.min' => 'El precio debe ser mayor o igual a 0.',
            'barcode.required' => 'El código de barras es obligatorio.',
            'barcode.unique' => 'Este código de barras ya existe.',
            'category_id.required' => 'Debe seleccionar una categoría.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ]);

        Car::create($validated);

        return redirect()
            ->route('cars.index')
            ->with('success', 'Carro creado correctamente.');
    }

    /**
     * 6. Mostrar detalle de un carro con su categoría
     */
    public function show(Car $car)
    {
        // Cargar la relación con categoría
        $car->load('category');

        return Inertia::render('Cars/Show', [
            'car' => $car,
        ]);
    }

    /**
     * 6. Mostrar formulario de edición
     */
    public function edit(Car $car)
    {
        // Obtener todas las categorías para el select
        $categories = Category::where('state', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return Inertia::render('Cars/Edit', [
            'car' => $car,
            'categories' => $categories,
        ]);
    }

    /**
     * 6. Actualizar carro
     */
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'car_make' => 'required|string|min:2|max:100',
            'car_model' => 'required|string|min:2|max:100',
            'car_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'car_price' => 'required|numeric|min:0',
            'car_status' => 'required|boolean',
            'barcode' => 'required|string|max:50|unique:cars,barcode,' . $car->id,
            'category_id' => 'required|exists:categories,id',
        ]);

        $car->update($validated);

        return redirect()
            ->back()
            ->with('success', 'Carro actualizado correctamente.');
    }

    /**
     * 6. Eliminar carro
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()
            ->back()
            ->with('success', 'Carro eliminado correctamente.');
    }
}
