<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name'=>'required|string',
            // 'email'=>'email|unique:users',
            'phone'=>'required|unique:users|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password'=>'required|min:8|confirmed'


        ];


    }

    // public function messages(): array
    // {
    //     return [
    //         'name.d' => 'Custom message for Email Required',
    //     ];
    // }
}
