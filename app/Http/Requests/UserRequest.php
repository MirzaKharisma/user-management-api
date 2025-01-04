<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public $validator;

    public function failedValidation(Validator $validator)
    {
        return $this->validator = $validator;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        }

        return $this->updateRules();
    }

    private function createRules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|numeric|digits_between:10,15',
            'active_status' => 'required',
            'department' => 'required'
        ];
    }

    private function updateRules(): array
    {
        return [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|numeric|digits_between:10,15',
            'active_status' => 'required',
            'department' => 'required'
        ];
    }
}
