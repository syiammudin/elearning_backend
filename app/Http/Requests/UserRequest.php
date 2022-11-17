<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'role' => 'required',
            'phone' => 'required',
            'id_number' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            'place_of_birth' => 'required',
            'gender' => 'required',
            'kelas' => 'required',
            'email' => 'required|email',
        ];
    }
}
