<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null && ($this->user()->role_id == Role::OPERATIONAL || $this->user()->role_id == Role::SUPER_ADMIN);
        // return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'notes' => ['required', 'max:200'],
            'image' => ['required', 'image:jpeg,png,jpg,gif,svg', 'max:2048']
        ];
    }
}
