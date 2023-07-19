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
            'biaya_inisiasi' => 'required',
            'biaya_operasional_tahunan' => 'required',
            'biaya_pemeliharaan_tahunan' => 'required',
            'biaya_pembongkaran' => 'required',
            'estimasi_tahunan' => 'required'
        ];
    }
}
