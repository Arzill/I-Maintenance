<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LccRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama_mesin' => 'required',
            'biaya_inisiasi' => 'required|numeric|min:0',
            'biaya_operasional_tahunan' => 'required|numeric|min:0',
            'biaya_pemeliharaan_tahunan' => 'required|numeric|min:0',
            'biaya_pembongkaran' => 'required|numeric|min:0',
            'estimasi_tahunan' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'nama_mesin.required' => 'Nama Mesin wajib diisi.',
            'biaya_inisiasi.required' => 'Biaya Inisiasi wajib diisi.',
            'biaya_inisiasi.numeric' => 'Biaya Inisiasi harus berupa angka.',
            'biaya_inisiasi.min' => 'Biaya Inisiasi harus lebih besar dari atau sama dengan 0.',
            'biaya_operasional_tahunan.required' => 'Biaya Operasional Tahunan wajib diisi.',
            'biaya_operasional_tahunan.numeric' => 'Biaya Operasional Tahunan harus berupa angka.',
            'biaya_operasional_tahunan.min' => 'Biaya Operasional Tahunan harus lebih besar dari atau sama dengan 0.',
            'biaya_pemeliharaan_tahunan.required' => 'Biaya Pemeliharaan Tahunan wajib diisi.',
            'biaya_pemeliharaan_tahunan.numeric' => 'Biaya Pemeliharaan Tahunan harus berupa angka.',
            'biaya_pemeliharaan_tahunan.min' => 'Biaya Pemeliharaan Tahunan harus lebih besar dari atau sama dengan 0.',
            'biaya_pembongkaran.required' => 'Biaya Pembongkaran wajib diisi.',
            'biaya_pembongkaran.numeric' => 'Biaya Pembongkaran harus berupa angka.',
            'biaya_pembongkaran.min' => 'Biaya Pembongkaran harus lebih besar dari atau sama dengan 0.',
            'estimasi_tahunan.required' => 'Estimasi Tahunan wajib diisi.',
            'estimasi_tahunan.numeric' => 'Estimasi Tahunan harus berupa angka.',
            'estimasi_tahunan.min' => 'Estimasi Tahunan harus lebih besar dari atau sama dengan 0.',
        ];
    }


}