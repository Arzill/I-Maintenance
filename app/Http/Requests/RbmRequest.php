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
            'jangka_waktu' => 'required',
            'severity' => 'required|integer|min:1|max:5',
            'occurrence' => 'required|integer|min:1|max:5',
            'risk' => 'required|string',
            'rekomendasi' => 'required|string',
        ];
    }
}