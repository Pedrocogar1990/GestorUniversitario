<?php

namespace App\Http\Controllers\Api;

use App\Models\Career;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CareerController extends Controller
{
   
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12);

        $careers = Career::when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('careerCode', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json($careers);
    }

  
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'careerCode' => 'required|string|max:20|unique:careers,careerCode',
            'duration' => 'required|integer|min:1|max:10',
        ]);

        $career = Career::create($validated);

        return response()->json($career, 201);
    }

 
    public function show(Career $career)
    {
        return response()->json($career);
    }

  
    public function update(Request $request, Career $career)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'careerCode' => 'required|string|max:20|unique:careers,careerCode,' . $career->id,
            'duration' => 'required|integer|min:1|max:10',
        ]);

        $career->update($validated);

        return response()->json($career);
    }

  
    public function destroy(Career $career)
    {
        $career->delete();

        return response()->json(['message' => 'Carrera eliminada']);
    }
}
