<?php

namespace App\Http\Requests\PemilikKos;

use App\Models\Wilayah;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isPemilikKos() ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_kos' => ['required', 'string', 'max:150'],
            'alamat' => ['required', 'string'],
            'wilayah_id' => ['required', 'integer', Rule::exists(Wilayah::class, 'id')],
        ];
    }
}
