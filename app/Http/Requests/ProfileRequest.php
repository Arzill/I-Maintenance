<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'no_hp' => 'nullable',
            'tempat_bekerja' => 'nullable',
            'posisi' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072'
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, atau jpg.',
            'image.max' => 'Ukuran gambar maksimum adalah 3072 KB (3 MB).',
        ];
    }
}
