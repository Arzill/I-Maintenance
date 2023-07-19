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
            'shift_end' => 'required',
            'planned_downtime' => 'required',
            'unplanned_downtime' => 'required',
            'total_parts_produced' => 'required',
            'ideal_cycle_time' => 'required',
            'total_scrap' => 'required',
        ];
    }
}
