<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prouctos = Producto::all();
        return response()->json($prouctos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string',
            'stock' => 'required|integer',
            'image_path' => 'nullable|image|dimensions:min_width=100,min_height=100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $image_path = $request->hasFile('image_path') ? $request->file('image_path')->store('public/productos') : null;

        Producto::create([
            'nombre' => $request->get('nombre'),
            'precio' => $request->get('precio'),
            'descripcion' => $request->get('descripcion'),
            'stock' => $request->get('stock'),
            'image_path' => $image_path,
        ]);

        return response()->json(['message' => 'Producto creado correctamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::find($id);
        return response()->json($producto);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto = Producto::find($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string',
            'stock' => 'required|integer',
            'image_path' => 'nullable|image|dimensions:min_width=100,min_height=100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $image_path = $request->hasFile('image_path') ? $request->file('image_path')->store('public/productos') : null;

        $producto->update([
            'nombre' => $request->get('nombre'),
            'precio' => $request->get('precio'),
            'descripcion' => $request->get('descripcion'),
            'stock' => $request->get('stock'),
            'image_path' => $image_path,
        ]);

        return response()->json(['message' => 'Producto actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::find($id);
        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }
        $producto->image_path ? Storage::delete($producto->image_path) : null;
        $producto->delete();
        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}
