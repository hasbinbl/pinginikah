<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class AddBalanceRequest extends FormRequest
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
            'amount' => 'required|numeric|min:1000',
            'type'   => 'required|in:add,subtract'
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Nominal saldo wajib diisi.',
            'amount.numeric'  => 'Nominal harus berupa angka.',
            'amount.min'      => 'Nominal tidak boleh kurang dari 1000 rupiah.',

            'type.required' => 'Aksi (Tambah/Kurang) wajib dipilih.',
            'type.in'       => 'Pilihan aksi tidak valid.',
        ];
    }
}
