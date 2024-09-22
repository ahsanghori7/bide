<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LastAssessmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'question_id' => $this->question_id,
            'answer' => $this->answer,
            'element_id' => $this->element_id,
            'element_value' => $this->element_value,
        ];
    }
}
