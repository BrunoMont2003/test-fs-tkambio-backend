<?php

namespace App\Core\Domain;

class Report
{
    public function __construct(
        public string $id,
        public string $title,
        public string $reportLink,
        public string $createdAt
    ) {}
}
