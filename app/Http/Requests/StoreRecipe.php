<?php

namespace App\Http\Requests;

use App\Http\Requests\Request as FormRequest;
use File;

class StoreRecipe extends FormRequest
{

    public function boot(){
        if($this->has('filepath')){
            $filename = '/photos/12/sac.png';
            $path = public_path($filename);
            $file = File::get($path);
            $type = File::mimeType($path);
            $this->merge(['img' => $file]);
            $validator->errors()->add('filepath',"TEST");
          }
    }

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
            'cooking_time_hour' => 'nullable|integer|between:0,24',
            'cooking_time_minute' => 'nullable|integer|between:0,59',
            'preparation_time_hour' => 'nullable|integer|between:0,24',
            'preparation_time_minute' => 'nullable|integer|between:0,59',
            'servings' => 'integer|between:0,20',
            // 'ingredient.*.quantity' => 'required_with:ingredient.*.name|max:100',
            'ingredient.*.name' => 'max:100',
        ];
    }


    /**
     * Validate request
     * @return
     */
    public function moreValidation($validator)
    {
        $validator->after(function($validator)
        {
            if($this->filled('filepath')){
                $filename = $this->input('filepath');
                $path = public_path($filename);
                $file = File::get($path);
            }
        });
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
            'anecdote.max' => 'L\'anecdote ne doit pas dépasser :max caractères',
            '*.integer' => ':attribute doit être un nombre',
            '*.between' => ':attribute doit être compris entre :min et :max',
            'ingredient.*.quantity.required_with' => 'Quantité requise',
            'ingredient.*.name.required_with' => 'Ingrédient requis',
            'ingredient.*.quantity.max' => ':max caractéres maximum',
            'ingredient.*.name.max' => ':max caractéres maximum',
        ];
    }
}
