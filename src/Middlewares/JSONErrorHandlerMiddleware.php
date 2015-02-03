<?php
/**
* OAuth error handler middleware
*
* @package   lucadegasperi/oauth2-server-laravel
* @author    Luca Degasperi <luca@lucadegasperi.com>
* @copyright Copyright (c) Luca Degasperi
* @licence   http://mit-license.org/
* @link      https://github.com/lucadegasperi/oauth2-server-laravel
*/

namespace LucaDegasperi\OAuth2Server\Middlewares;

use Closure;
use Illuminate\Contracts\Routing\Middleware;
use Illuminate\Http\JsonResponse;
use League\OAuth2\Server\Exception\OAuthException;

class JSONErrorHandlerMiddleware implements Middleware
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (OAuthException $e) {
            // catch any OAuthException and return the results as JSON
            return new JsonResponse([
                    'error'             => $e->errorType,
                    'error_description' => $e->getMessage()
                ],
                $e->httpStatusCode,
                $e->getHttpHeaders()
            );
        }
    }
}
