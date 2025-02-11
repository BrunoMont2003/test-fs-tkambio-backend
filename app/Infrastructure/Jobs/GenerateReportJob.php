<?php

namespace App\Infrastructure\Jobs;

use App\Core\Application\UseCases\GenerateReport;
use App\Core\Application\DTOs\GenerateReportDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected GenerateReportDTO $dto;

    public function __construct(GenerateReportDTO $dto)
    {
        $this->dto = $dto;
    }

    public function handle(GenerateReport $generateReportUseCase)
    {
        $generateReportUseCase->execute($this->dto);
    }
}
