<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectAttachmentRequest extends FormRequest
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
        if ($this->request->has('project_attachment_id')) {
            $rules = [
                'name' => 'required|string|max:30',
                'description' => 'nullable|string|max:100',
                'file' => 'nullable',
                'user_id' => 'required|numeric|gt:0|exists:users,id',
                'project_id' => 'required|numeric|gt:0|exists:projects,id',
            ];
        } else {
            $rules['file'] = 'required';
        }


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
            'name.required' => 'Il nome dell\'allegato del progetto è obbligatorio',
            'name.max' => 'Il nome dell\'allegato del progetto può essere di massimo 30 caratteri',
            'description.max' => 'La descrizione dell\'allegato del progetto può essere di massimo 100 caratteri',
            'user_id.exists' => 'L\'utente selezionato non esiste nel nostro database',
            'project_id.exists' => 'Il progetto selezionato non esiste nel nostro database'
        ];
    }
}