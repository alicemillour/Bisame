<?php

namespace App\Http\Requests;

use App\Http\Requests\Request as FormRequest;
use File;

class StorePoem extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',
            'content' => 'required|max:2000',
            'anecdote' => 'max:2000',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Le nom de la recette est requis',
            'title.max' => 'Le nom de la recette ne doit pas dépasser :max caractères',
            'content.required' => 'La description de la recette est requise',
            'content.max' => 'La description de la recette ne doit pas dépasser :max caractères',
            'anecdote.max' => 'L\'anecdote ne doit pas dépasser :max caractères'
        ];
    }
}
