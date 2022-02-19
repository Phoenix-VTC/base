<?php

namespace App\Http\Requests\Api\Multiplayer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResolveLocationRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'game' => strtolower($this->game),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'x' => ['required', 'numeric'],
            'y' => ['required', 'numeric'],
            'game' => ['required', 'string', Rule::in('ets2', 'ats')],
        ];
    }
}
