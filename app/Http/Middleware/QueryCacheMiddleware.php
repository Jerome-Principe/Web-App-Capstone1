<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class QueryCacheMiddleware
{
    /**
     * Handle an incoming request and implement query caching
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only cache GET requests that don't contain sensitive data
        if ($request->isMethod('GET') && !$this->containsSensitiveData($request)) {
            $cacheKey = $this->generateCacheKey($request);

            // Check if we have cached response
            if (Cache::has($cacheKey)) {
                $cachedResponse = Cache::get($cacheKey);

                return response($cachedResponse['content'])
                    ->withHeaders($cachedResponse['headers']);
            }

            // Process request
            $response = $next($request);

            // Cache successful responses for 5 minutes
            if ($response->getStatusCode() === 200) {
                $this->cacheResponse($cacheKey, $response);
            }

            return $response;
        }

        return $next($request);
    }

    /**
     * Check if request contains sensitive data that shouldn't be cached
     */
    private function containsSensitiveData(Request $request): bool
    {
        $sensitiveRoutes = [
            'login',
            'register',
            'password',
            'admin',
            'profile',
            'account'
        ];

        $path = $request->path();

        foreach ($sensitiveRoutes as $sensitive) {
            if (str_contains($path, $sensitive)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate cache key for request
     */
    private function generateCacheKey(Request $request): string
    {
        return 'page_cache_' . md5($request->fullUrl() . serialize($request->query()));
    }

    /**
     * Cache the response
     */
    private function cacheResponse(string $cacheKey, Response $response): void
    {
        $cacheData = [
            'content' => $response->getContent(),
            'headers' => $response->headers->all()
        ];

        // Cache for 5 minutes
        Cache::put($cacheKey, $cacheData, 300);
    }
}
