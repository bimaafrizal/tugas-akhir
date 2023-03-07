<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEwsRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'min:5'],
            'location' => ['nullable', 'max:255', 'min:5'],
            'api_url' => ['required', 'max:255', 'min:5'],
            'api_key' => ['nullable', 'max:255'],
            'longitude' => ['nullable', 'max:255'],
            'latitude' => ['nullable', 'max:255'],
            'gmaps_link' => ['nullable', 'max:255'],
        ];
    }
}
