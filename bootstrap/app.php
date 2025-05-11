<?php

use App\Enums\HttpStatus;
use App\Http\Middleware\PermissionMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/test')
                ->name('test.')
                ->group(base_path('routes/test.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias(['permissions' => PermissionMiddleware::class]);
//         dd($middleware->getMiddlewareAliases());

        $middleware->redirectGuestsTo(function () {
            throw new HttpException(HttpStatus::UNAUTHORIZED, 'Unauthenticated');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // This configuration sets up a single render function to handle all exceptions.
        // It determines the appropriate HTTP status code based on the type of the exception.
        $exceptions->render(function (Exception $e) {
            // If the exception is an instance of HttpException, it uses the status code from the exception.
            // Otherwise, it defaults to a 500 status code for generic exceptions.
            $status = $e instanceof HttpException ? $e->getStatusCode() : 500;
            return response()->json(['error' => [config('common.generic_error') => $e->getMessage()]], $status);
        });
    })->create();
