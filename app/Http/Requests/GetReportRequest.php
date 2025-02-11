<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetReportRequest extends FormRequest
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
            'report_id' => 'required|integer|exists:reports,id',
        ];
    }
}
