<?php

namespace Cone\Laravel\Auth\Http\Requests;

use Cone\Laravel\Auth\Interfaces\Requests\ResendRequest as Contract;
use Illuminate\Foundation\Http\FormRequest;

class ResendRequest extends FormRequest implements Contract
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
            'email' => ['required', 'string', 'email', 'max:256'],
        ];
    }
}
