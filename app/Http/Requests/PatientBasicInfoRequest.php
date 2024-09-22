<?php

namespace App\Http\Requests;

use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PatientBasicInfoRequest extends FormRequest
{
    protected $patient_id;

    protected function prepareForValidation()
    {
        $this->patient_id = $this->route('id');
    }

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
            'name' => 'required|max:255',
            'cnic' => 'required|max:13|unique:patient_info,cnic,' . $this->patient_id,
            'mobile_number' => 'required|max:11',
            'mr_no' => 'required|unique:patient_info,mr_no,' . $this->patient_id,
            'gender' => 'required|max:6',
            'dob' => 'required',
            'address' => 'required|max:255',

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
                'cnic.unique' => trans('errors.cnic_unique'),
            ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ApiResponse::error($validator->errors()->first(), 422));
    }
}
