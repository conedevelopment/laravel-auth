<?php

namespace Cone\Laravel\Auth\Http\Requests;

use Cone\Laravel\Auth\Interfaces\Requests\ResetPasswordRequest as Contract;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest implements Contract
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
        return [
            'token' => ['required'],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }
}
