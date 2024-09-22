<?php

namespace App\Http\Resources;

use App\Models\EducationalAssessmentQuestionOptions;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentQuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'question_id' => $this->id,
            'section' => $this->section,
            'question' => $this->question,
            'elements' => EducationalAssessmentQuestionOptions::select('id', 'question_id', 'type', 'option')
                ->where('question_id', $this->id)->whereNull('parent_id')->get(),
        ];
    }
}
