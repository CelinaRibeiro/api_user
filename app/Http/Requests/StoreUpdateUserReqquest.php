<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateUserReqquest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|min:3|max:255',
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:6', 'max:50'],
        ];

        if ($this->method() === 'PATCH') {
            $rules['name'] = [
               'sometimes', 'min:3', 'max:255',
            ];
            $rules['email'] = [
                // 'sometimes', 'email', 'max:255', "unique:users,email,{$this->id},id",
                Rule::unique('users')->ignore($this->id),
             ];
             $rules['password'] = [
                'sometimes', 'min:6', 'max:50',
             ];
        }

        return $rules;
    }
}
