<?php

namespace App\Core\Application\UseCases;

use App\Core\Application\DTOs\GetReportDTO;
use App\Core\Domain\Interfaces\ReportRepositoryInterface;
use App\Core\Domain\Report;

class GetReport
{
    private ReportRepositoryInterface $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * Obtiene un reporte por su ID.
     *
     * @param GetReportDTO $dto
     * @return Report|null
     */
    public function execute(GetReportDTO $dto): Report|null
    {
        $report = $this->reportRepository->getById($dto->reportId);

        if (!$report) {
            return null;
        }

        return $report;
    }
}
