<?php

namespace App\Helpers;
use App\Services\LogService;
use Carbon\Carbon;

class LogHelper
{
    public const CONTRACT_LOG = 1;

    public const TRANSACTION_LOG = 2;

    public const PAYMENT_LOG = 3;

    public const WITHDRAW_LOG = 4;

    public const APPLICATION_LOG = 5;

    public LogService $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }
    public function search(array $data): array
    {
        return $this->logService->search($data);
    }
    public function logApplication(string|array $message, int $loggable, int $user_id): void
    {
        $this->log($message, $this::APPLICATION_LOG, $loggable, $user_id);
    }
    public function logContract(string|array $message, int $loggable, int $user_id): void
    {
        $this->log($message, $this::CONTRACT_LOG, $loggable, $user_id);
    }
    private function log(string $message, int $type, int $loggable, int $user_id)
    {
        $data = [
            'model_id' => $loggable,
            'model_type' => config('log_service.log_types')[$type],
            'message' => $message,
            'created_by' => $user_id,
            'created_at' => Carbon::now()->toIso8601String(),
        ];

        $this->logService->create($data);
    }
}
