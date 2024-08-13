<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo|max:255',
            'imagen' => 'nullable',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        $imagen = $request->file('imagen') ? file_get_contents($request->file('imagen')->getRealPath()) : null;
    
        Cliente::create([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'direccion' => $request->get('direccion'),
            'correo' => $request->get('correo'),
            'imagen' => $imagen,
        ]);
    
        return response()->json(['message' => 'Cliente creado correctamente'], 201);   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        if($cliente->null){
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
        $imagen = $cliente->imagen ? base64_encode($cliente->imagen) : null;

        return response()->json([
            'nombre' => $cliente->nombre,
            'apellido' => $cliente->apellido,
            'direccion' => $cliente->direccion,
            'correo' => $cliente->correo,
            'imagen' => $imagen,
        ]);
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'apellido' => 'string|max:255',
            'direccion' => 'string|max:255',
            'correo' => 'email|unique:clientes,correo,' . $id . '|max:255',
            'imagen' => 'image',
        ]);
    
        if ($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
    
        $cliente = Cliente::findOrFail($id);

        if($cliente->null){
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        if($request->has('nombre')){
            $cliente->nombre = $request->get('nombre');
        }

        if($request->has('apellido')){
            $cliente->apellido = $request->get('apellido');
        }

        if($request->has('direccion')){
            $cliente->direccion = $request->get('direccion');
        }

        if($request->has('correo')){
            $cliente->correo = $request->get('correo');
        }   
    
        if ($request->hasFile('imagen')) {
            $cliente->imagen = file_get_contents($request->file('imagen')->getRealPath());
        }

        $cliente->save();
    
        return response()->json(['message' => 'Cliente actualizado correctamente'], 200);   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        if($cliente->null){
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
        $cliente->delete();
        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }
}
