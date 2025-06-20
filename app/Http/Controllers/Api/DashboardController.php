<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Career;
use App\Models\Enrollment;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
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
}
