<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OeeRequest extends FormRequest
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
            'waktu_mulai_produksi' => 'required',
            'waktu_selesai_produksi' => 'required|after:waktu_mulai_produksi',
            'jenis_downtime' => 'nullable',
            'jam_mulai_downtime' => 'nullable',
            'jam_selesai_downtime' => 'nullable|after:jam_mulai_downtime',
            'mulai_downtime_terencana' => 'nullable',
            'selesai_downtime_terencana' => 'nullable|after:mulai_downtime_terencana',
            'total_produksi' => 'required',
            'tingkat_produksi_ideal' => 'required',
            'produksi_cacat' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'nama_mesin.required' => 'Nama Mesin wajib diisi.',
            'waktu_mulai_produksi.required' => 'Waktu mulai produksi wajib diisi.',
            'waktu_selesai_produksi.required' => 'Waktu selesai produksi wajib diisi.',
            'waktu_selesai_produksi.after' => 'Waktu selesai produksi harus lebih besar dari waktu mulai produksi.',
            // 'jenis_downtime.required' => 'Jenis downtime wajib diisi.',
            'jam_mulai_downtime.required' => 'Waktu mulai downtime wajib diisi.',
            'jam_selesai_downtime.required' => 'Waktu selesai downtime wajib diisi.',
            'jam_selesai_downtime.after' => 'Waktu selesai downtime harus lebih besar dari waktu mulai downtime.',
            'selesai_downtime_terencana.after' => 'Waktu selesai downtime terencana harus lebih besar dari waktu mulai downtime terncana.',
            'total_produksi.required' => 'Total Parts Produced wajib diisi.',
            'tingkat_produksi_ideal.required' => 'Ideal Run Rate wajib diisi.',
            'produksi_cacat.required' => 'Total Scrap wajib diisi.',
        ];
    }
}