<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'User_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string|unique:users',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Governorate' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'birthdate' => 'date_format:Y-M-D|before:today',
            'gender' => 'in:m,f',
        ];
    }
}
