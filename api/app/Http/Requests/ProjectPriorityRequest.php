<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectPriorityRequest extends FormRequest
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


        if($this->request->has('project_priority_id')){
            $rules['name'] = ['required', 'string','max:30',Rule::unique('project_priorities')->ignore($this->request->get('project_priority_id'))];
            $rules['priority_level'] = ['required', 'integer', Rule::unique('project_priorities')->ignore($this->request->get('project_priority_id'))];
            $rules['icon'] = ['nullable', 'string' , Rule::unique('project_priorities')->ignore($this->request->get('project_priority_id'))];
            $rules['color'] = ['nullable', 'string' , Rule::unique('project_priorities')->ignore($this->request->get('project_priority_id'))];
        } else {
            $rules['name'] = 'required|unique:project_priorities|string|max:30';
            $rules['priority_level'] = 'required|unique:project_priorities|integer';
            $rules['icon'] = 'nullable|unique:project_priorities|string';
            $rules['color'] = 'nullable|unique:project_priorities|string';
        }

        return $rules;
    }

    public function messages()
    {
        return [

            'name.required' => 'Il nome della priorità è obbligatorio',
            'name.unique' => 'Il nome della priorità è già utilizzato',
            'name.max' => 'il nome della priorità può essere di massimo 30 caratteri',
            'priority_level.required' => 'Il livello della priorità è obbligatorio',
            'priority_level.integer' => 'Il livello della priorità deve essere un numero intero',
            'priority_level.unique' => 'Il livello della priorità è già utilizzato',
            'icon.unique' => "l'icona della priorità è già utilizzata",
            'color.unique' => "il colore della priorità è già utilizzata",
            'description.max' => 'la descrizione del priorità può essere di massimo 100 caratteri',
        ];
    }
}