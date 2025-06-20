<?php

namespace App\Http\Controllers\Api;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 12);

        $enrollments = Enrollment::with(['student', 'subject'])
            ->when($search, function ($query, $search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('lastName', 'like', "%{$search}%");
                })->orWhereHas('subject', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json($enrollments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'registration_date' => 'required|date',
        ]);

        $enrollment = Enrollment::create($validated);

        return response()->json($enrollment->load(['student', 'subject']), 201);
    }

    public function show(Enrollment $enrollment)
    {
        return response()->json($enrollment->load(['student', 'subject']));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'registration_date' => 'required|date',
        ]);

        $enrollment->update($validated);

        return response()->json($enrollment->load(['student', 'subject']));
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return response()->json(['message' => 'Matrícula eliminada']);
    }
}
