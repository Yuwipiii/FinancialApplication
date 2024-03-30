<?php

namespace App\Http\Requests;

use App\Models\Wallet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ExpenseCreateRequest extends FormRequest
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
            'category_id'=>['nullable','exists:categories,id'],
            'amount'=>['required','numeric','min:1'],
            'date'=>['required','date'],
            'currency_id'=>['required','exists:currencies,id'],
            'note'=>['nullable','string','min:3']
        ];
    }
}
