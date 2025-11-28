<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class StoreWalletRequest extends FormRequest
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
            'account_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'account_name.required' => 'Nama pemilik rekening wajib diisi.',
            'account_name.string'   => 'Nama pemilik harus berupa teks.',
            'account_name.max'      => 'Nama pemilik terlalu panjang (maksimal 255 karakter).',

            'bank_name.required' => 'Nama Bank atau Wallet wajib diisi (contoh: BCA, Gopay).',
            'bank_name.string'   => 'Nama Bank harus berupa teks.',
            'bank_name.max'      => 'Nama Bank terlalu panjang (maksimal 255 karakter).',

            'balance.required' => 'Saldo awal wajib diisi (isi 0 jika kosong).',
            'balance.numeric'  => 'Format saldo harus berupa angka.',
            'balance.min'      => 'Saldo awal tidak boleh kurang dari 0.',
        ];
    }
}
