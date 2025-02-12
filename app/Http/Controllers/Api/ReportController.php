<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\Application\UseCases\GenerateReport;
use App\Core\Application\UseCases\GetReport;
use App\Core\Application\UseCases\ListReports;
use App\Core\Application\DTOs\GenerateReportDTO;
use App\Core\Application\DTOs\GetReportDTO;
use App\Core\Application\DTOs\ListReportsDTO;
use App\Core\Application\DTOs\SaveReportDTO;
use App\Core\Application\UseCases\SaveReport;
use App\Http\Requests\GenerateReportRequest;
use App\Http\Requests\GetReportRequest;
use App\Http\Requests\ListReportsRequest;
use App\Infrastructure\Jobs\GenerateReportJob;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    private SaveReport $saveReportUseCase;
    private GenerateReport $generateReportUseCase;
    private GetReport $getReportUseCase;
    private ListReports $listReportsUseCase;

    public function __construct(
        SaveReport $saveReportUseCase,
        GenerateReport $generateReportUseCase,
        GetReport $getReportUseCase,
        ListReports $listReportsUseCase
    ) {
        $this->saveReportUseCase = $saveReportUseCase;
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

        $report = $this->saveReportUseCase->execute(new SaveReportDTO(
            title: $request->input('title'),
            reportLink: null,
            status: 'pending',
            createdAt: now(),
        ));

        $dto = new GenerateReportDTO(
            $report,
            $request->input('birthDateFrom'),
            $request->input('birthDateTo')
        );

        // GenerateReportJob::dispatch($dto);
        $this->generateReportUseCase->execute($dto);

        return response()->json([
            'message' => 'Report generation started. You will be notified once it is ready.',
            'report' => $report
        ], 202);
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
