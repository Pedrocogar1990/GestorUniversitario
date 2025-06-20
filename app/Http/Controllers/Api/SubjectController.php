<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12);

        $query = Subject::with(['career', 'professor']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subjectCode', 'like', "%{$search}%");
            });
        }

        $subjects = $query->orderBy('id', 'desc')->paginate($perPage);

        return response()->json($subjects);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subjectCode' => 'required|string|max:100|unique:subjects,subjectCode',
            'credits' => 'required|integer|min:0',
            'career_id' => 'required|exists:careers,id',
            'professor_id' => 'nullable|exists:professors,id',
        ]);

        $subject = Subject::create($validated);

        return response()->json($subject, 201);
    }

 
    public function show(Subject $subject)
    {
        $subject->load(['career', 'professor']);
        return response()->json($subject);
    }

    
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'subjectCode' => 'sometimes|required|string|max:100|unique:subjects,subjectCode,' . $subject->id,
            'credits' => 'sometimes|required|integer|min:0',
            'career_id' => 'sometimes|required|exists:careers,id',
            'professor_id' => 'nullable|exists:professors,id',
        ]);

        $subject->update($validated);

        return $subject;
    }

    
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return response()->json(null, 204);
    }
}
