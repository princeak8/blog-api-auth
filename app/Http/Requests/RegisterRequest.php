<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
        $rules = [
            'domain' => 'required|string',
            'domain_name' => 'required|string',
            // 'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ];

        $rules['email'] = [
            'required','email', 'string', 'max:255', 
            Rule::unique("users")->where(fn ($query) => $query->where("role", 'user'))
        ];

        return $rules;
    }
}
