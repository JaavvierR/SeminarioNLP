<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PaisController extends Controller
{
    protected $pais;

    public function index()
    {
        $paises = Pais::all();
        return response()->json($paises);
    }


    public function show($id)
    {
        $pais = Pais::find($id);
        if ($pais) {
            return response()->json($pais);
        } else {
            return response()->json(['error' => 'País no encontrado'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_pais' => 'required|string|max:255',
        ]);

        $pais = Pais::create($request->all());
        return response()->json($pais, 201);
    }

    public function update(Request $request, $id)
    {
        $pais = Pais::find($id);
        if ($pais) {
            $request->validate([
                'nom_pais' => 'nullable|string|max:255',
            ]);

            $pais->update($request->all());
            return response()->json($pais);
        } else {
            return response()->json(['error' => 'País no encontrado'], 404);
        }
    }

    public function destroy($id)
    {
        $pais = Pais::find($id);
        if ($pais) {
            $pais->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'País no encontrado'], 404);
        }
    }

}
