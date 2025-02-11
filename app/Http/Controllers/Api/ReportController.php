<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\Application\UseCases\GenerateReport;
use App\Core\Application\UseCases\GetReport;
use App\Core\Application\UseCases\ListReports;
use App\Core\Application\DTOs\GenerateReportDTO;
use App\Core\Application\DTOs\GetReportDTO;
use App\Core\Application\DTOs\ListReportsDTO;
use App\Http\Requests\GenerateReportRequest;
use App\Http\Requests\GetReportRequest;
use App\Http\Requests\ListReportsRequest;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    private GenerateReport $generateReportUseCase;
    private GetReport $getReportUseCase;
    private ListReports $listReportsUseCase;

    public function __construct(
        GenerateReport $generateReportUseCase,
        GetReport $getReportUseCase,
        ListReports $listReportsUseCase
    ) {
        $this->generateReportUseCase = $generateReportUseCase;
        $this->getReportUseCase = $getReportUseCase;
        $this->listReportsUseCase = $listReportsUseCase;
    }

    /**
     * Genera un reporte.
     *
     * @param GenerateReportRequest $request
     * @return JsonResponse
     */
    public function generateReport(GenerateReportRequest $request): JsonResponse
    {
        $dto = new GenerateReportDTO(
            $request->input('title'),
            $request->input('birth_date_from'),
            $request->input('birth_date_to')
        );
        $report = $this->generateReportUseCase->execute($dto);

        return response()->json([
            'message' => 'Report generated successfully.',
            'report' => $report
        ], 201);
    }

    /**
     * Obtiene un reporte por su ID.
     *
     * @param string $reportId
     * @return JsonResponse
     */
    public function getReport(string $reportId): JsonResponse
    {
        $dto = new GetReportDTO($reportId);
        $report = $this->getReportUseCase->execute($dto);

        if (!$report) {
            return response()->json([
                'message' => 'Report not found.'
            ], 404);
        }
        return response()->json([
            'report' => $report
        ]);
    }

    /**
     * Lista todos los reportes.
     *
     * @param ListReportsRequest $request
     * @return JsonResponse
     */
    public function listReports(ListReportsRequest $request): JsonResponse
    {
        $dto = new ListReportsDTO(
            $request->input('date_range') ?: null,
            $request->input('page') ?: 1,
            $request->input('limit') ?: 10,
        );
        $reports = $this->listReportsUseCase->execute($dto);
        $totalReports = $this->listReportsUseCase->getTotalReports($dto);

        return response()->json([
            'reports' => $reports,
            'metadata' => [
                'totalReports' => $totalReports,
                'currentPage' => $dto->getPage(),
                'totalPages' => ceil($totalReports / $dto->getLimit()),
            ],
        ]);
    }
}
