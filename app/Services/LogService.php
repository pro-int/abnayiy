<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LogService
{
    public function create(array $data): void
    {
        try {
            $http= Http::withHeaders(['x-api-key' => config('log_service.api_key')])->post(config('log_service.base_url').'/'.config('log_service.stage').config('log_service.create_path'), $data);
         Log::info($http->json());
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function search(array $data): ?array
    {
        try {
            Log::info($data);
            $http = Http::withHeaders(['x-api-key' => config('log_service.api_key')])->post(config('log_service.base_url').'/'.config('log_service.stage').config('log_service.search_path'), $data);
            Log::info($http->json());
            return $http->json();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    public function serviceStatus(): bool
    {
        try {
            $response = Http::withHeaders(['x-api-key' => config('log_service.api_key')])->get(config('log_service.base_url').'/'.config('log_service.stage').config('log_service.health_path'));
            Log::info($response);
            return $response->ok();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
