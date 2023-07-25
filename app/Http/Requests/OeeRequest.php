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
            'shift_start' => 'required',
            'shift_end' => 'required|after:shift_start',
            'planned_downtime' => 'required',
            'unplanned_downtime' => 'required',
            'total_parts_produced' => 'required',
            'ideal_run_rate' => 'required',
            'total_scrap' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'nama_mesin.required' => 'Nama Mesin wajib diisi.',
            'shift_start.required' => 'Shift Start wajib diisi.',
            'shift_end.required' => 'Shift End wajib diisi.',
            'planned_downtime.required' => 'Planned Downtime wajib diisi.',
            'unplanned_downtime.required' => 'Unplanned Downtime wajib diisi.',
            'total_parts_produced.required' => 'Total Parts Produced wajib diisi.',
            'ideal_run_rate.required' => 'Ideal Run Rate wajib diisi.',
            'total_scrap.required' => 'Total Scrap wajib diisi.',
            'shift_end.after' => 'Shift End harus lebih besar dari Shift Start.',
        ];
    }
}
