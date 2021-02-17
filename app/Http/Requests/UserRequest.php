<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if connected user is the user we want to edit
        if($this->user()->id == $this->route('user')->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'nullable',
                'string',
                'max:64',
                'unique:users,username,'.$this->route('user')->id, // One way of validating a unique field with exception
            ],
            'lastname' => [
                'nullable',
                'string',
                'max:64',
            ],
            'firstname' => [
                'nullable',
                'string',
                'max:64',
            ],
            'email' => [
                'nullable',
                'email',
                'max:256',
                Rule::unique('users')->ignore($this->route('user')), // Another way of validating a unique field with exception 
            ],
            'password' => [
                //'sometimes', // https://laravel.com/docs/8.x/validation#validating-when-present
                'nullable',
                'string',
                'confirmed',
                'min:8',
            ],
            'birthdate' => [
                'present',
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator) {

    }
}
