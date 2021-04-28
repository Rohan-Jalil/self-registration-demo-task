<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'address1' => 'required|string',
            'address2' => 'string|nullable',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'zipCode' => 'required|integer|digits_between:1,20',
            'phoneNo1' => 'required|string|max:20',
            'phoneNo2' => 'string|nullable|max:20',
            'user.firstName' => 'required|string|max:50',
            'user.lastName' => 'required|string|max:50',
            'user.email' => 'required|email|max:150|unique:users,email',
            'user.password' => 'required|same:user.passwordConfirmation',
            'user.phone' => 'required|string|max:20',
        ];
    }
}
