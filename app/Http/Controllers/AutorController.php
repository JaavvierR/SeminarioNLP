<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Autor;

class AutorController extends Controller
{
    public function index()
    {
        $autores = Autor::all();
        return response()->json($autores);
    }

    public function show($id)
    {
        $autor = Autor::find($id);
        if ($autor) {
            return response()->json($autor);
        } else {
            return response()->json(['error' => 'Autor no encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $autor = Autor::create($request->all());
        return response()->json($autor, 201);
    }

    public function update(Request $request, $id)
    {
        $autor = Autor::find($id);
        if ($autor) {
            $request->validate([
                'nombre' => 'nullable|string|max:255',
            ]);

            $autor->update($request->all());
            return response()->json($autor);
        } else {
            return response()->json(['error' => 'Autor no encontrado'], 404);
        }
    }

    public function destroy($id)
    {
        $autor = Autor::find($id);
        if ($autor) {
            $autor->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Autor no encontrado'], 404);
        }
    }
}
