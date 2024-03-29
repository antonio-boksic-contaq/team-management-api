<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
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


        
        $rules['name'] = $this->request->has('team_id') ? 
        [
            'required',
            'string',
            'max:30',
            Rule::unique('teams')->ignore($this->request->get('team_id'))
        ] :
        'required|unique:teams|string|max:30';

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
            'name.required' => 'Il titolo del team è obbligatorio',
            'name.unique' => 'Il titolo del team è già utilizzato',
            'name.max' => 'il titolo del team può essere di massimo 30 caratteri',
            'description.max' => 'la descrizione del team può essere di massimo 100 caratteri',
        ];
    }
}