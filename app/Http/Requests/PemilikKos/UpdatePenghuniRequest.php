<?php

namespace App\Http\Requests\PemilikKos;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePenghuniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isPemilikKos() ?? false;
    }

    public function rules(): array
    {
        return [
            'jenis_identitas' => ['required', Rule::in(['KTP', 'SIM'])],
            'nomor_identitas' => ['required', 'string', 'max:30'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'tanggal_masuk' => ['required', 'date', 'before_or_equal:today'],
        ];
    }
}
