<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\Career;
use App\Models\Professor;
use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    public function run()
    {
        $careers = Career::all();
        $professors = Professor::all();

        $subjects = [
            ['name' => 'Programación I', 'subjectCode' => 'PROG-101', 'credits' => 4, 'career_id' => $careers->where('careerCode', 'IS-001')->first()->id, 'professor_id' => $professors->where('dni', '12345678')->first()->id],
            ['name' => 'Anatomía Humana', 'subjectCode' => 'ANAT-201', 'credits' => 6, 'career_id' => $careers->where('careerCode', 'MED-002')->first()->id, 'professor_id' => $professors->where('dni', '87654321')->first()->id],
            ['name' => 'Contabilidad Básica', 'subjectCode' => 'CONT-301', 'credits' => 3, 'career_id' => $careers->where('careerCode', 'ADM-003')->first()->id, 'professor_id' => $professors->where('dni', '11223344')->first()->id],
            ['name' => 'Derecho Penal', 'subjectCode' => 'DERP-401', 'credits' => 5, 'career_id' => $careers->where('careerCode', 'DER-004')->first()->id, 'professor_id' => $professors->where('dni', '44332211')->first()->id],
            ['name' => 'Psicología Social', 'subjectCode' => 'PSIS-501', 'credits' => 4, 'career_id' => $careers->where('careerCode', 'PSI-005')->first()->id, 'professor_id' => $professors->where('dni', '55667788')->first()->id],
            ['name' => 'Dibujo Arquitectónico', 'subjectCode' => 'DIBQ-601', 'credits' => 4, 'career_id' => $careers->where('careerCode', 'ARQ-006')->first()->id, 'professor_id' => $professors->where('dni', '88776655')->first()->id],
            ['name' => 'Cálculo Estructural', 'subjectCode' => 'CALC-701', 'credits' => 5, 'career_id' => $careers->where('careerCode', 'IC-007')->first()->id, 'professor_id' => $professors->where('dni', '99001122')->first()->id],
            ['name' => 'Enfermería Clínica', 'subjectCode' => 'ENFC-801', 'credits' => 6, 'career_id' => $careers->where('careerCode', 'ENF-008')->first()->id, 'professor_id' => $professors->where('dni', '22110099')->first()->id],
            ['name' => 'Biología Celular', 'subjectCode' => 'BIOC-901', 'credits' => 4, 'career_id' => $careers->where('careerCode', 'BIO-009')->first()->id, 'professor_id' => $professors->where('dni', '33445566')->first()->id],
            ['name' => 'Microeconomía', 'subjectCode' => 'MICR-1001', 'credits' => 3, 'career_id' => $careers->where('careerCode', 'ECO-010')->first()->id, 'professor_id' => $professors->where('dni', '66554433')->first()->id],
            ['name' => 'Periodismo Digital', 'subjectCode' => 'PERD-1101', 'credits' => 4, 'career_id' => $careers->where('careerCode', 'COM-011')->first()->id, 'professor_id' => $professors->where('dni', '77889900')->first()->id],
            ['name' => 'Química Orgánica', 'subjectCode' => 'QUIM-1201', 'credits' => 5, 'career_id' => $careers->where('careerCode', 'QUI-012')->first()->id, 'professor_id' => $professors->where('dni', '00998877')->first()->id],
            ['name' => 'Álgebra Lineal', 'subjectCode' => 'ALGB-1301', 'credits' => 4, 'career_id' => $careers->where('careerCode', 'MAT-013')->first()->id, 'professor_id' => $professors->where('dni', '12348765')->first()->id],
        ];

        Subject::insert($subjects);
    }
}