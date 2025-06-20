<?php

namespace App\Http\Controllers\Api;

use App\Models\Professor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12);

        $professors = Professor::when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('dni', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json($professors);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'lastname'   => 'required|string|max:255',
            'dni'        => 'required|string|max:20|unique:professors,dni',
            'email'      => 'required|email|unique:professors,email',
            'department' => 'required|string|max:255',
            'tutor'      => 'required|boolean',
        ]);

        $professor = Professor::create($validated);

        return response()->json($professor, 201);
    }

    public function show(Professor $professor)
    {
        return response()->json($professor);
    }

    public function update(Request $request, Professor $professor)
    {
        $validated = $request->validate([
            'name'       => 'sometimes|required|string|max:255',
            'lastname'   => 'sometimes|required|string|max:255',
            'dni'        => 'sometimes|required|string|max:20|unique:professors,dni,' . $professor->id,
            'email'      => 'sometimes|required|email|unique:professors,email,' . $professor->id,
            'department' => 'sometimes|required|string|max:255',
            'tutor'      => 'sometimes|required|boolean',
        ]);

        $professor->update($validated);

        return response()->json($professor);
    }

    public function destroy(Professor $professor)
    {
        $professor->delete();
        return response()->json(['message' => 'Profesor eliminado correctamente.']);
    }
}
