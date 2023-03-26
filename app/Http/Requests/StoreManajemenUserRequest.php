<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManajemenUserRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'email:dns', 'unique:users,email'],
            'phone_num' => ['required', 'min:9', 'max:13', 'unique:users,phone_num'],
            'password' => ['required', 'confirmed', 'min:5', 'max:255'],
            'role_id' => ['required']
        ];
    }
}
