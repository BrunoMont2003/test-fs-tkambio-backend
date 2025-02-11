<?php

namespace App\Core\Application\DTOs;

class GenerateReportDTO
{
    public function __construct(
        public string $title,
        public string $birthDateFrom,
        public string $birthDateTo,
    ) {}
}
