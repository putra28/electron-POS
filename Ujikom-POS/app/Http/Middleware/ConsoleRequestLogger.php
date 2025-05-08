<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConsoleRequestLogger
{
    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);
        /** @var Response $response */
        $response = $next($request);
        $duration = round((microtime(true) - $start) * 1000, 2);

        $method = $request->method();
        $url = $request->fullUrl();
        $status = $response->getStatusCode();

        // Warna ANSI
        $color = match (true) {
            $status >= 500 => "\033[0;31m", // merah
            $status >= 400 => "\033[0;33m", // kuning
            $status >= 300 => "\033[0;36m", // cyan
            $status >= 200 => "\033[0;32m", // hijau
            default        => "\033[0m",    // reset
        };

        $reset = "\033[0m";

        if (app()->runningInConsole()) {
            fwrite(STDOUT, "{$color}[{$status}] {$method} {$url} - {$duration} ms{$reset}\n");
        }

        return $response;
    }
}
