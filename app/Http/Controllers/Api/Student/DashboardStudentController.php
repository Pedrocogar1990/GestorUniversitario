<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Career;
use App\Models\Enrollment;
use Illuminate\Http\JsonResponse;

class DashboardStudentController extends Controller
{
  
    public function index(): JsonResponse
    {
        return response()->json([
            'students' => Student::count(),
            'professors' => Professor::count(),
            'careers' => Career::count(),
            'enrollments' => Enrollment::count(),
        ]);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

  
    public function destroy(string $id)
    {
        //
    }
}
