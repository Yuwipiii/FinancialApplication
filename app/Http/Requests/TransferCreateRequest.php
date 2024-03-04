<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TransferCreateRequest extends FormRequest
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
            'from_wallet_id'=>['required','exists:wallets,id'],
            'to_wallet_id'=>['required','exists:wallets,id'],
            'amount'=>['required','numeric','min:1'],
            'note'=>['nullable','string','min:3'],
            'currency_id'=>['required','exists:currencies,id'],
            'date'=>['required','date'],
        ];
    }
}
