<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRegisterRequests extends FormRequest
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
            'name'=>'required|string|max:255',
            'country'=>'required|string|max:255',
            'description'=>'required|string',
            'subject'=>'required',
            'image'=>'required|image',
            'video'=>'required|mimes:mp4,mov,ogg',
            'CostHour'=>'required|numeric',
            'phone'=>'required|unique:teachers|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password'=>'required|min:8|confirmed',
        ];
    }
}
