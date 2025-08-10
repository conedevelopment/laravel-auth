<?php

namespace Cone\Laravel\Auth\Http\Requests;

use Cone\Laravel\Auth\Interfaces\Requests\AuthCodeVerifyRequest as Contract;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;

class AuthCodeVerifyRequest extends FormRequest implements Contract
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
            'code' => [
                'required',
                'numeric',
                Rule::exists('auth_codes', 'code')->where(function (Builder $query): Builder {
                    return $query->where('user_id', $this->user()->getKey())
                        ->where('expires_at', '>', Date::now());
                }),
            ],
        ];
    }
}
