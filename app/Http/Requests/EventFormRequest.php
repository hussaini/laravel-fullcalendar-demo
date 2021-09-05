<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'start_at' => $this->input('startAt'),
            'end_at' => $this->input('endAt'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => ['bail', 'required', 'max:255'],
            'details' => ['bail', 'nullable', 'max:255'],
            'start_at' => ['bail', 'date'],
            'end_at' => ['bail', 'nullable', 'date'],
            'is_enabled' => ['bail', 'sometimes', 'required', 'boolean'],
        ];
    }
}
