<?php

namespace App\Infrastructure\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelService
{
    /**
     * Genera un archivo Excel.
     *
     * @param array $users
     * @param string $title
     * @return string
     */
    public function generateReport(array $users, string $title): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados
        $sheet->setCellValue('A1', 'Nombre');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Fecha de Nacimiento');
        $sheet->setCellValue('D1', 'Fecha de Registro');

        // Datos
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->name);
            $sheet->setCellValue('B' . $row, $user->email);
            $sheet->setCellValue('C' . $row, $user->birthDate);
            $sheet->setCellValue('D' . $row, $user->createdAt);
            $row++;
        }

        $fileName = "{$title}_" . now()->format('YmdHis') . ".xlsx";
        $filePath = storage_path("app/public/{$fileName}");

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return url("storage/{$fileName}");
    }
}
