<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenggunaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'          => 'required|string|max:255',
            'asal_sekolah'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'username'      => 'required|string|unique:users,username|max:100',
            'nomor_hp'      => 'required|string|unique:users,nomor_hp|max:20',
            'nomor_hp2'     => 'string|max:20',
            'role'          => 'required|string|exists:roles,name',
            'password'      => 'required|string|min:6|confirmed',
            'status'        => 'sometimes|string|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'         => 'Nama lengkap wajib diisi.',
            'asal_sekolah.required' => 'Asal sekolah wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah digunakan.',
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username sudah digunakan.',
            'nomor_hp.required'     => 'Nomor HP wajib diisi.',
            'nomor_hp.unique'       => 'Nomor HP sudah digunakan.',
            'nomor_hp2.max'         => 'Nomor Whatsapp tidak boleh lebih dari 20 karakter.',
            'role.required'         => 'Role wajib dipilih.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak sesuai.',
        ];
    }
}
