<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BorrowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'book' => ['numeric', 'exists:books,id']
        ];
    }

    /**
     * The custom messages for each validation rule.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'book' => [
                'exists' => "Your library doesn't have this book!"
            ]
        ];
    }
}
