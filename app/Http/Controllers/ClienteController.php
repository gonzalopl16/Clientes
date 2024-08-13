<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json($clientes);
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
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo|max:255',
            'imagen' => 'nullable|image',
        ]);

        $imagen = $request->file('imagen') ? file_get_contents($request->file('imagen')) : null;

        Cliente::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'direccion' => $validated['direccion'],
            'correo' => $validated['correo'],
            'imagen' => $imagen,
        ]);

        return response()->json(['message' => 'Cliente creado correctamente'], 201);   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $cliente = Cliente::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo,' . $id . '|max:255',
            'imagen' => 'nullable|image',
        ]);

        if ($request->hasFile('imagen')) {
            $cliente->imagen = file_get_contents($request->file('imagen'));
        }

        $cliente->update([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'direccion' => $validated['direccion'],
            'correo' => $validated['correo'],
        ]);

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}
