<?php

namespace App\Http\Requests;

use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\FloatNumber;

class PersonalHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'mother_diabetic_text' => ['nullable', new FloatNumber()],
            'spouse_diabetic_text' => ['nullable', new FloatNumber()],
            'brother_diabetic_text' => ['nullable', new FloatNumber()],
            'sister_diabetic_text' => ['nullable', new FloatNumber()],
            'children_diabetic_text' => ['nullable', new FloatNumber()],
            'live_birth_text' => ['nullable', new FloatNumber()],
            'still_birth_text' => ['nullable', new FloatNumber()],
            'neonatal_deaths_text' => ['nullable', new FloatNumber()],
            'abortiont_ext' => ['nullable', new FloatNumber()],
            'patient_id' => 'required|numeric|exists:patient_info,id'
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return
            [
                'name.required' => trans('errors.name_required'),
                'name.max' => trans('errors.name_max'),
                'cnic.required' => trans('errors.cnic_required'),
                'cnic.max' => trans('errors.cnic_max'),
                'mobile_number.required' => trans('errors.mobile_number_required'),
                'mobile_number.unique' => trans('errors.already_exist'),
                'mobile_number.max' => trans('errors.mobile_number_max'),
                'mr_no.required' => trans('errors.mr_no_required'),
                'mr_no.unique' => trans('errors.unique_mr'),
                'mr_no.max' => trans('errors.mr_no_max'),
                'gender.required' => trans('errors.gender_required'),
                'gender.max' => trans('errors.gender_max'),
                'dob.required' => trans('errors.dob_required'),
                'address.required' => trans('errors.address_required'),
                'address.max' => trans('errors.address_max'),
                'patient_id.required' => trans('errors.patient_id_required'),
                'patient_id.numeric' => trans('errors.patinet_id_numaric'),
                'patient_id.exists' => trans('errors.patinet_id_invalid'),
            ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error($validator->errors()->first(), 422));
    }
}
