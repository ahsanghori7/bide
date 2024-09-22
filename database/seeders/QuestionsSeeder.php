<?php

namespace Database\Seeders;

use App\Models\EducationalAssessmentQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('educational_assessment_questions')->truncate();

        $questions = [
            ['question' => 'Is patient taking OHA?', 'section' => 'default'],
            ['question' => 'Correct timing', 'section' => 'default'],
            ['question' => 'Regular intake', 'section' => 'default'],
            ['question' => 'Previously taking insulin', 'section' => 'default'],
            ['question' => 'Does patient know benefit of insulin?', 'section' => 'default'],
            ['question' => 'Advised Insulin', 'section' => 'default'],
            ['question' => 'Remove misconceptions', 'section' => 'default'],
            ['question' => 'Injecting patient', 'section' => 'default'],
            ['question' => 'Multiple dosage of syringe/needle', 'section' => 'default'],
            ['question' => 'Mode of storage', 'section' => 'default'],
            ['question' => 'importance of SMBG advised', 'section' => 'smbg'],
            ['question' => 'Glucometer own or advised?', 'section' => 'smbg'],
            ['question' => 'Meter calibration counseling', 'section' => 'smbg'],
            ['question' => 'Advised Targets', 'section' => 'smbg'],
            ['question' => 'BG checking from Labs', 'section' => 'smbg'],
            ['question' => 'Knowledge of Hypoglycemia', 'section' => 'hypocalcemia'],
            ['question' => 'Signs and symptoms', 'section' => 'hypocalcemia'],
            ['question' => 'Treatment information', 'section' => 'hypocalcemia'],
            ['question' => 'Advised Targets', 'section' => 'hypocalcemia'],
            ['question' => 'Exercise advised', 'section' => 'exercise'],
            ['question' => 'Timing of exercise', 'section' => 'exercise'],
            ['question' => 'Footcare during exercise', 'section' => 'exercise'],
            ['question' => 'Hypo exercise', 'section' => 'exercise'],

        ];


        foreach ($questions as $question) {
            EducationalAssessmentQuestion::create([
                'section' => $question['section'],
                'question' => $question['question'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
