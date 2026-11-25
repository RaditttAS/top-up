<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProdukTopUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_produk' => [
                'required',
                'string',
                'max:20',
                'unique:produk_topup,kode_produk',
                Rule::unique('produk_topup', 'kode_produk'),
            ],
            'jumlah_diamond' => ['required', 'integer', 'min:1', 'max:2147483647'],
            'harga' => ['required', 'integer', 'min:1', 'max:9000000000000'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode_produk.required' => 'Kode produk wajib diisi.',
            'kode_produk.max' => 'Kode produk maksimal :max karakter.',
            'kode_produk.unique' => 'Kode produk sudah digunakan.',
            'jumlah_diamond.required' => 'Jumlah diamond wajib diisi.',
            'jumlah_diamond.integer' => 'Jumlah diamond harus berupa angka bulat.',
            'jumlah_diamond.min' => 'Jumlah diamond minimal :min.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka bulat.',
            'harga.min' => 'Harga minimal Rp:min.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kode_produk' => 'Kode Produk',
            'jumlah_diamond' => 'Jumlah Diamond',
            'harga' => 'Harga',
        ];
    }
}
