<?php

namespace App\Http\Requests\Walllet;

use App\Models\Wallet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class WalletCreateRequest extends FormRequest
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
            'name'=>['required','max:40','min:3'],
            'type'=>['required'],
            'currency'=>['required',Rule::in(Wallet::CURRENCIES)],
            'balance'=>['required','integer','not_in:0','regex:^[1-9][0-9]+^']
        ];
    }
}
