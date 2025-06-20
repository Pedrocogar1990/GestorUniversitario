<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12);

        $students = Student::with('career')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('lastName', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('dni', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:students,dni',
            'email' => 'required|email|unique:students,email',
            'birthDate' => 'required|date',
            'career_id' => 'required|exists:careers,id',
        ]);

        return Student::create($validated);
    }

    public function show(Student $student)
    {
        return $student->load('career');
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:students,dni,' . $student->id,
            'email' => 'required|email|unique:students,email,' . $student->id,
            'birthDate' => 'required|date',
            'career_id' => 'required|exists:careers,id',
        ]);

        $student->update($validated);

        return $student;
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json(['message' => 'Estudiante eliminado']);
    }
}
