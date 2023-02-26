<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'title' => 'required|min:3|max:255',
            'slug' => 'required',
            'kategory_article_id' => 'required',
            'body' =>  'required|min:10',
            'cover' => 'required|file|image|mimes:jpg,jpeg,png|max:50000'
        ];
    }
}
