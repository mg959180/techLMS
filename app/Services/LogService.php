<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogService
{
    public function debug(string $message, array $context = [], string $channel = 'admin'): void
    {
        Log::channel($channel)->debug($message, $this->sanitizeContext($context));
    }

    public function info(string $message, array $context = [], string $channel = 'admin'): void
    {
        Log::channel($channel)->info($message, $this->sanitizeContext($context));
    }

    public function warning(string $message, array $context = [], string $channel = 'admin'): void
    {
        Log::channel($channel)->warning($message, $this->sanitizeContext($context));
    }

    public function error(string $message, array $context = [], ?Throwable $exception = null, string $channel = 'admin'): void
    {
        if ($exception) {
            $context['exception'] = [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ];
        }

        Log::channel($channel)->error($message, $this->sanitizeContext($context));
    }

    public function adminActivity(string $action, ?Request $request = null, array $context = []): void
    {
        $this->info($action, array_merge($this->requestContext($request), $context));
    }

    public function requestContext(?Request $request): array
    {
        if (! $request) {
            return [];
        }

        return [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_agent' => $request->userAgent(),
        ];
    }

    private function sanitizeContext(array $context): array
    {
        foreach (['password', 'password_confirmation', 'token', 'payload', 'remember_token'] as $key) {
            if (array_key_exists($key, $context)) {
                $context[$key] = '[hidden]';
            }
        }

        return $context;
    }
}
