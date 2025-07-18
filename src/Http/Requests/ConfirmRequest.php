<?php

namespace Cone\Laravel\Auth\Http\Requests;

use Cone\Laravel\Auth\Interfaces\Requests\ConfirmRequest as Contract;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmRequest extends FormRequest implements Contract
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! is_null($this->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'string', 'current_password'],
        ];
    }
}
