<?php

namespace App\Core\Application\DTOs;

class ListReportsDTO
{
    private ?array $dateRange;
    private int $page;
    private int $limit;

    public function __construct(?array $dateRange = null, int $page = 1, int $limit = 10)
    {
        $this->dateRange = $dateRange;
        $this->page = $page;
        $this->limit = $limit;
    }

    public function getDateRange(): ?array
    {
        return $this->dateRange;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
