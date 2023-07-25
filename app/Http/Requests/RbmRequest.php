<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RbmRequest extends FormRequest
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
            'jangka_waktu' => 'required|integer|min:1|max:12',
            'severity' => 'required|integer|min:1|max:5',
            'occurrence' => 'required|integer|min:1|max:5',
            'risk' => 'required|string',
            'rekomendasi' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'nama_mesin.required' => 'Nama Mesin wajib diisi.',
            'jangka_waktu.required' => 'Jangka Waktu wajib diisi.',
            'jangka_waktu.integer' => 'Jangka Waktu harus berupa angka.',
            'jangka_waktu.min' => 'Jangka Waktu harus lebih besar dari atau sama dengan 1.',
            'jangka_waktu.max' => 'Jangka Waktu tidak boleh lebih dari 12 bulan.',
            'severity.required' => 'Severity wajib diisi.',
            'severity.integer' => 'Severity harus berupa angka.',
            'severity.min' => 'Severity harus lebih besar dari atau sama dengan 1.',
            'severity.max' => 'Severity harus kurang dari atau sama dengan 5.',
            'occurrence.required' => 'Occurrence wajib diisi.',
            'occurrence.integer' => 'Occurrence harus berupa angka.',
            'occurrence.min' => 'Occurrence harus lebih besar dari atau sama dengan 1.',
            'occurrence.max' => 'Occurrence harus kurang dari atau sama dengan 5.',
            'risk.required' => 'Risk wajib diisi.',
            'rekomendasi.required' => 'Rekomendasi wajib diisi.',
        ];
    }
}
