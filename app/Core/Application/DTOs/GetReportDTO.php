<?php

namespace App\Core\Application\DTOs;

class GetReportDTO
{
    public function __construct(
        public string $reportId
    ) {}
}
