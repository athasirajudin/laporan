<?php

namespace App\Http\Requests\PemilikKos;

use App\Models\Penghuni;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MarkPenghuniKeluarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isPemilikKos() ?? false;
    }

    public function rules(): array
    {
        $penghuni = $this->route('penghuni');
        $tanggalMasuk = $penghuni instanceof Penghuni ? $penghuni->tanggal_masuk?->format('Y-m-d') : null;

        return [
            'tanggal_keluar' => [
                'required',
                'date',
                'before_or_equal:today',
                Rule::when($tanggalMasuk !== null, "after_or_equal:{$tanggalMasuk}"),
            ],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
