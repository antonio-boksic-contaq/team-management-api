<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectStatusRequest extends FormRequest
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


        if($this->request->has('project_status_id')){
            $rules['name'] = ['required', 'string','max:30',Rule::unique('project_statuses')->ignore($this->request->get('project_priority_id'))];
            $rules['icon'] = ['nullable', 'string' , Rule::unique('project_statuses')->ignore($this->request->get('project_priority_id'))];
            $rules['color'] = ['nullable', 'string' , Rule::unique('project_statuses')->ignore($this->request->get('project_priority_id'))];
        } else {
            $rules['name'] = 'required|unique:project_statuses|string|max:30';
            $rules['icon'] = 'nullable|unique:project_statuses|string';
            $rules['color'] = 'nullable|unique:project_statuses|string';
        }

        return $rules;
    }

    public function messages()
    {
        return [

            'name.required' => 'Il nome dello stato è obbligatorio',
            'name.unique' => 'Il nome dello stato è già utilizzato',
            'name.max' => 'il nome dello stato può essere di massimo 30 caratteri',
            'icon.unique' => "l'icona dello stato è già utilizzata",
            'color.unique' => "il colore dello stato è già utilizzato",
            'description.max' => 'la descrizione dello stato può essere di massimo 100 caratteri',
        ];
    }
}
