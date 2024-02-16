<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        'name' => 'required|string|max:100',
        'description' => 'nullable|string|max:300',
        'notes' => 'nullable|string|max:300',
        'deadline_date' => 'nullable|date|after:now',
        'start_date' => 'missing', //questa non dovrebbe essere inseribile in fase di creazione
        'end_date' => 'missing', //questa non dovrebbe essere inseribile in fase di creazione
        'expected_hours' => 'numeric|gt:0',
        'project_id' => 'required|numeric|exists:projects,id',
        'task_status_id' => 'required|numeric|exists:task_statuses,id',
        'task_priority_id' => 'required|numeric|exists:task_priorities,id',
        ];



        // qua bisognerebbe aggiungere il controllo che solo utente a cui è assegnato il task può modifcare queste due
        if($this->request->has('task_id')) {
            //questo lo può cambiare solo utente a cui è assegnato il task
            $rules['start_date'] = 'nullable|date';
            // questo pure
            $rules['end_date'] = 'nullable|date';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Il nome del task è obbligatorio',
            'name.max' => 'Il nome del task può essere di massimo 100 caratteri',
            'description.max' => 'La descrizione del task può essere di massimo 100 caratteri',
            'notes.max' => 'Le note del task può essere di massimo 100 caratteri',
            'deadline_date.after' => 'La data della deadline deve essere posteriore rispetto alla data di oggi',
            'start_date.missing' => 'La data di inizio del task non può essere inserita in fase di creazione',
            'end_date.missing' => 'La data di fine del task non può essere inserita in fase di creazione',
            'project_id.required' => "Il progetto da associare al task è obbligatiorio",
            'task_status_id.required' => "lo status da associare al task è obbligatiorio",
            'task_priority_id.required' => "la priorità da associare al task è obbligatiorio",
        ];
    }
}