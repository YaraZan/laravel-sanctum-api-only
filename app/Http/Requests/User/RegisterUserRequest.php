<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:5|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|max:20|min:10',
            'confirm_password' => 'required|max:20|min:10',
            'device_name' => 'required',
            'location' => 'required',
        ];
    }
}
