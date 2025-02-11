<?php

namespace App\Core\Application\DTOs;

use App\Core\Domain\Report;

class GenerateReportDTO
{
    public function __construct(
        public Report $report,
        public string $birthDateFrom,
        public string $birthDateTo,
    ) {}
}
