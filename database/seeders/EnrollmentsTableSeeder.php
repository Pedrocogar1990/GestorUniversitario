<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class EnrollmentsTableSeeder extends Seeder
{
    public function run()
    {
        $students = Student::all();
        $subjects = Subject::all();

        
        $startDate = strtotime('2023-09-01'); 
        $endDate = strtotime('2024-06-30');  

        foreach ($students as $student) {
            $randomSubjects = $subjects->random(rand(2, 4)); 
            foreach ($randomSubjects as $subject) {
               
                $randomDate = date('Y-m-d', rand($startDate, $endDate));

                Enrollment::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'registration_date' => $randomDate,
                ]);
            }
        }
    }
}