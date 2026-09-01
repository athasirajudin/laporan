<?php

namespace App\Http\Requests\PemilikKos;

use App\Models\Kos;
use App\Models\Wilayah;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKosRequest extends FormRequest
{
    public function authorize(): bool
    {
        $kos = $this->route('kos');

        return $this->user()?->isPemilikKos() === true
            && $kos instanceof Kos
            && $kos->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'nama_kos' => ['required', 'string', 'max:150'],
            'alamat' => ['required', 'string'],
            'wilayah_id' => [
                'required',
                'integer',
                Rule::exists(Wilayah::class, 'id'),
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $kos = $this->route('kos');

                    if ($kos instanceof Kos && $kos->status === 'active' && (int) $value !== $kos->wilayah_id) {
                        $fail('Wilayah kos yang sudah aktif tidak dapat dipindahkan melalui akun pemilik.');
                    }
                },
            ],
        ];
    }
}
