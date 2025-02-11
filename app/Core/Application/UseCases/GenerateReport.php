<?php

namespace App\Core\Application\UseCases;

use App\Core\Application\DTOs\GenerateReportDTO;
use App\Core\Domain\Interfaces\ReportRepositoryInterface;
use App\Core\Domain\Interfaces\UserRepositoryInterface;
use App\Core\Domain\Report;
use App\Infrastructure\Services\ExcelService;
use Ramsey\Uuid\Uuid;

class GenerateReport
{
    private UserRepositoryInterface $userRepository;
    private ReportRepositoryInterface $reportRepository;
    private ExcelService $excelService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ReportRepositoryInterface $reportRepository,
        ExcelService $excelService
    ) {
        $this->userRepository = $userRepository;
        $this->reportRepository = $reportRepository;
        $this->excelService = $excelService;
    }

    public function execute(GenerateReportDTO $dto): Report
    {
        $users = $this->userRepository->getAllByBirthDate($dto->birthDateFrom, $dto->birthDateTo);

        $reportLink = $this->excelService->generateReport($users, $dto->title);

        $report = new Report(
            id: Uuid::uuid4()->toString(),
            title: $dto->title,
            reportLink: $reportLink,
            createdAt: now()->toDateTimeString()
        );

        $this->reportRepository->save($report);

        return $report;
    }
}
