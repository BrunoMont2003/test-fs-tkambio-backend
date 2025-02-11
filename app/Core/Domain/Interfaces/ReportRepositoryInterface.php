<?php

namespace App\Core\Domain\Interfaces;

use App\Core\Domain\Report;

interface ReportRepositoryInterface
{
    /**
     * Guarda un reporte.
     *
     * @param Report $report
     * @return void
     */
    public function save(Report $report): void;

    /**
     * Actualiza un reporte.
     *
     * @param Report $report
     * @return void
     */
    public function update(Report $report): void;

    /**
     * Obtiene un reporte por su ID.
     *
     * @param string $reportId
     * @return Report|null
     */
    public function getById(string $reportId): ?Report;

    /**
     * Obtiene todos los reportes.
     *
     * @return Report[]
     */
    public function getAll(): array;

    /**
     * Obtiene reportes filtrados.
     *
     * @param array|null $dateRange
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getFilteredReports(?array $dateRange, int $limit, int $offset): array;

    /**
     * Obtiene el total de reportes.
     *
     * @param array|null $dateRange
     * @return int
     */
    public function count(?array $dateRange): int;
}
