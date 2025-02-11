<?php

namespace App\Core\Application\DTOs;


class SaveReportDTO
{
    public function __construct(
        public string $title,
        public ?string $reportLink,
        public string $status,
        public string $createdAt
    ) {}
}
