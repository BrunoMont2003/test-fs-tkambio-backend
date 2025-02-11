<?php

namespace App\Core\Application\UseCases;

use App\Core\Application\DTOs\ListReportsDTO;
use App\Core\Domain\Interfaces\ReportRepositoryInterface;
use App\Core\Domain\Report;

class ListReports
{
    private ReportRepositoryInterface $reportRepository;

    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    /**
     * Obtiene todos los reportes.
     *
     * @param ListReportsDTO $dto
     * @return Report[]
     */
    public function execute(ListReportsDTO $dto): array
    {
        $offset = ($dto->getPage() - 1) * $dto->getLimit();
        return $this->reportRepository->getFilteredReports($dto->getDateRange(), $dto->getLimit(), $offset);
    }

    /**
     * Obtiene el total de reportes.
     *
     * @param ListReportsDTO $dto
     * @return int
     */
    public function getTotalReports(ListReportsDTO $dto): int
    {
        $offset = ($dto->getPage() - 1) * $dto->getLimit();
        return $this->reportRepository->count($dto->getDateRange(), $dto->getLimit(), $offset);
    }
}
