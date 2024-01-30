<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'gender' => Rule::in(['M', 'F', 'N']),
            'team_id' => 'numeric|gt:0|exists:teams,id',
        ];

        if($this->request->has('user_id')){
            $rules['email'] = ['required', 'email', Rule::unique('users')->ignore($this->request->get('user_id'))];
        }

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => 'Il nome è obbligatorio',
            'lastname.required' => 'Il cognome è obbligatorio',
            'email.required' => 'L\'email è obbligatoria',
            'email.email' => 'L\'email inserita non è valida',
            'email.unique' => 'L\'email inserita è stata già utilizzata per un altro utente',
            'gender.in' => 'Il sesso inserito non è valido',
        ];
    }
}
