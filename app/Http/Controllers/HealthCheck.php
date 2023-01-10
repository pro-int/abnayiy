<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\ArrayShape;

class HealthCheck extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    #[ArrayShape(['database' => 'bool', 'redis' => 'bool', 'sockets' => 'bool', 'logs' => 'bool', 'firebase' => 'bool', 'sms' => 'bool'])]
    public function __invoke(Request $request): array
    {
        return [
            'database' => $this->checkDatabaseStatus(),
//            'redis' => $this->checkRedisStatus(),
//            'sockets' => $this->checkSocketsStatus(),
            'logs' => $this->checkLogsStatus(),
            'firebase' => $this->checkFirebaseStatus(),
//            'sms' => $this->checkSMSStatus(),
        ];
    }

    protected function checkDatabaseStatus(): bool
    {
        $isConnected = true;
        try {
            \Illuminate\Support\Facades\DB::connection()->getPdo();
        } catch (\Exception $_) {
            $isConnected = false;
        }

        return $isConnected;
    }

    protected function checkRedisStatus(): bool
    {
        $isConnected = true;
        try {
            $redis = \Illuminate\Support\Facades\Redis::connection();
            $redis->connect();
            $redis->disconnect();
        } catch (\Exception $_) {
            $isConnected = false;
        }

        return $isConnected;
    }

    protected function checkSocketsStatus(): bool
    {
        return app(\App\Services\SocketService::class)->serviceStatus();
    }

    protected function checkLogsStatus(): bool
    {
        return app(\App\Services\LogService::class)->serviceStatus();
    }

    protected function checkFirebaseStatus(): bool
    {
        return true;
    }

    protected function checkSMSStatus(): bool
    {
        return \App\Http\Helpers\SmsHelper::serviceStatus();
    }
}
