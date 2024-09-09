<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Libro;



class LibroController extends Controller
{
    private $libro;


    public function index()
    {
        $libros = Libro::with(['autor', 'pais'])->get();
        return response()->json($libros);
    }


    public function show($id)
    {
        $libro = Libro::with(['autor', 'pais'])->find($id);
        if ($libro) {
            return response()->json($libro);
        } else {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor_id' => 'required|exists:autores,id',
            'pais_id' => 'required|exists:paises,id',
            'fecha' => 'required|date',
        ]);

        $libro = Libro::create($request->all());
        return response()->json($libro, 201);
    }

    public function update(Request $request, $id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            $request->validate([
                'titulo' => 'nullable|string|max:255',
                'autor_id' => 'nullable|exists:autores,id',
                'pais_id' => 'nullable|exists:paises,id',
                'fecha' => 'nullable|date',
            ]);

            $libro->update($request->all());
            return response()->json($libro);
        } else {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }
    }

    public function destroy($id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            $libro->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }
    }

}


