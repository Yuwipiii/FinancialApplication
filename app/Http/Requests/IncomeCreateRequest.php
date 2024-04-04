<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class IncomeCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'wallet_id'=>['required','exists:wallets,id'],
            'income_category_id'=>['nullable','exists:income_categories,id'],
            'amount'=>['required','numeric','min:1'],
            'date'=>['required','date'],
            'note'=>['nullable','string','min:3']
        ];
    }
}
