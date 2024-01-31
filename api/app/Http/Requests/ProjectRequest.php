<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
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

        $rules =[
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:200',
            'project_priority_id' => 'required|exists:project_priorities,id',
            // progress deve essere 0 di default, non lo voglio nella request
            'progress' => 'missing',
            'deadline_date' => 'required|date|after:now',
            'end_date' =>'nullable|date',
            'project_status_id' => 'required|exists:project_statuses,id', 
            'project_applicant_id' => 'nullable|exists:project_applicants,id', 
            'project_category_id' => 'nullable|exists:project_categories,id', 
        ];

        /*
        if($this->request->has('project_id')) {
            $rules['project_status_id'] = ['required', 'exists:project_statuses,id'];
        }
        */

        return $rules;

    }



    public function messages()
    {
        return [
            'name.required' => 'Il nome del progetto è obbligatorio',
            'name.max' => 'Il nome del progetto può essere di massimo 100 caratteri',
            'description.max' => 'La descrizione del progetto può essere di massimo 100 caratteri',
            'notes.max' => 'Le note del progetto possono essere di massimo 200 caratteri',
            'project_priority_id.required' => 'La priorità del progetto è obbligatoria',
            'project_priority_id.exists' => 'La priorità selezionata non esiste',
            'deadline_date.required' => 'La data di scadenza del progetto è obbligatoria',
            'deadline_date.date' => 'La data di scadenza del progetto deve essere in formato data AAAA/MM/GG',
            'deadline_date.after' =>'La data di scadenza del progetto non deve essere passata',
            'end_date.date' => 'La data di completamento del progetto deve essere in formato data AAAA/MM/GG',
            'project_status_id.required' => 'Lo stato del progetto è obbligatorio',
            'project_status_id.exists' => 'Lo stato del progetto selezionato non esiste',
            'project_applicant_id.required' => 'Il richiedente del progetto è obbligatorio',
            'project_applicant_id.exists' => 'Il richiedente del progetto selezionato non esiste',
            'project_category_id.required' => 'La categoria del progetto è obbligatoria',
            'project_category_id.exists' => 'La categoria del progetto selezionata non esiste',
            //l'idea è di creare un altra Request che useremo per gestire aggiornamento di "progress" quando vengono completati dei task.
            'progress.missing' => 'Il progresso del progetto non può essere impostato tramite richiesta HTTP durante creazione e modifica progetto.'
        ];
    }
}
