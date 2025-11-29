<?php

namespace App\Http\Requests\Wedding;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeddingRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'date'  => 'nullable|date',
            'role'  => 'required|in:groom,bride',
            'partner_email' => 'required|email|max:255',

            'segments'   => 'required|array|min:1',
            'segments.*' => 'required|string|max:255|distinct',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'         => 'Judul wajib diisi.',
            'partner_email.required' => 'Harus mengundang pasangan Anda.',
            'partner_email.email'    => 'Format email pasangan salah.',
            'segments.required'      => 'Anda wajib membuat minimal satu bagian acara (misal: Akad).',
            'segments.*.required'    => 'Nama bagian acara tidak boleh kosong.',
            'segments.*.distinct'    => 'Nama bagian acara tidak boleh sama.',
        ];
    }
}
