<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectCategoryRequest extends FormRequest
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
        $rules = 
        [
        'description' => 'nullable|string|max:100',
        ];


        
        $rules['name'] = $this->request->has('project_category_id') ? 
        [
            'required',
            'string',
            'max:30',
            Rule::unique('project_categories')->ignore($this->request->get('project_category_id'))
        ] :
        'required|unique:project_categories|string|max:30';

        return $rules;
    }

    /**
     * Get the validation rule messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => 'Il nome della categoria del progetto è obbligatorio',
            'name.unique' => 'Il nome della categoria del progetto è già utilizzato',
            'name.max' => 'il nome della categoria del progetto può essere di massimo 30 caratteri',
            'description.max' => 'la descrizione della categoria del progetto può essere di massimo 100 caratteri',
        ];
    }
}
