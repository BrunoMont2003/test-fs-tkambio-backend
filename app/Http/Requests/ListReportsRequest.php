<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListReportsRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para la solicitud.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'dateRange' => 'array|nullable',
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1',
        ];
    }
}
