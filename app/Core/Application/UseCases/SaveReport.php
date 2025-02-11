<?php

namespace App\Core\Application\UseCases;

use App\Core\Application\DTOs\SaveReportDTO;
use App\Core\Domain\Interfaces\ReportRepositoryInterface;
use App\Core\Domain\Report;
use Ramsey\Uuid\Uuid;

class SaveReport
{
    private ReportRepositoryInterface $reportRepository;

    public function __construct(
        ReportRepositoryInterface $reportRepository,
    ) {
        $this->reportRepository = $reportRepository;
    }

    public function execute(SaveReportDTO $dto): Report
    {
        $report = new Report(
            id: Uuid::uuid4()->toString(),
            title: $dto->title,
            reportLink: $dto->reportLink,
            createdAt: $dto->createdAt,
            status: $dto->status,
        );
        $this->reportRepository->save($report);

        return $report;
    }
}
