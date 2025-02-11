<?php

namespace App\Infrastructure\Repositories;

use App\Core\Domain\Report;
use App\Core\Domain\Interfaces\ReportRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportRepositoryInterface
{
    /**
     * Guarda un reporte.
     *
     * @param Report $report
     * @return void
     */
    public function save(Report $report): void
    {
        DB::table('reports')->insert([
            'id' => $report->id,
            'title' => $report->title,
            'report_link' => $report->reportLink,
            'created_at' => $report->createdAt,
        ]);
    }

    /**
     * Obtiene un reporte por su ID.
     *
     * @param string $reportId
     * @return Report|null
     */
    public function getById(string $reportId): ?Report
    {
        $report = DB::table('reports')->where('id', $reportId)->first();

        if (!$report) {
            return null;
        }

        return new Report(
            id: $report->id,
            title: $report->title,
            reportLink: $report->report_link,
            createdAt: $report->created_at
        );
    }

    /**
     * Obtiene todos los reportes.
     *
     * @return Report[]
     */
    public function getAll(): array
    {
        $reports = DB::table('reports')->get();

        return $reports->map(function ($report) {
            return new Report(
                id: $report->id,
                title: $report->title,
                reportLink: $report->report_link,
                createdAt: $report->created_at
            );
        })->toArray();
    }

    /**
     * Obtiene reportes filtrados.
     *
     * @param array|null $dateRange
     * @param int $limit
     * @param int $offset
     * @return Report[]
     */
    public function getFilteredReports(?array $dateRange, int $limit, int $offset): array
    {
        $reports = DB::table('reports')
            ->when($dateRange, function ($query, $dateRange) {
                $query->whereBetween('created_at', $dateRange);
            })
            ->skip($offset)
            ->take($limit)
            ->get();

        return $reports->toArray();
    }

    /**
     * Obtiene el total de reportes.
     *
     * @param array|null $dateRange
     * @param int|null $limit
     * @param int|null $offset
     * @return int
     */
    public function count(?array $dateRange, ?int $limit, ?int $offset): int
    {
        return DB::table('reports')
            ->when($dateRange, function ($query, $dateRange) {
                $query->whereBetween('created_at', $dateRange);
            })
            ->when($limit, function ($query, $limit) {
                $query->take($limit);
            })
            ->when($offset, function ($query, $offset) {
                $query->skip($offset);
            })
            ->count();
    }
}
