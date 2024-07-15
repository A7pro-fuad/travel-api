<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        //  using: function () {
        // // Route::middleware('api')
        // //     ->prefix('api/v1')
        // //     ->group(base_path('routes/api.php'));

        // Route::middleware('web')
        //     ->group(base_path('routes/web.php'));}
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        apiPrefix: 'api/v1',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
        // $middleware->api(append: [
        //     RoleMiddleware::class,
        // ]);
        //  $middleware->appendToGroup('api/v1',[RoleMiddleware::class]);
        //     $middleware->group('api/v1', [
        //     //     \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        //     //     'throttle:api',
        //      \Illuminate\Routing\Middleware\SubstituteBindings::class,
        //      ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReportDuplicates();
        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->wantsJson()) {
                return response()->json(
                    [
                        'error' => 'Entry for ' . str_replace('App', '', $e->getModel()) . ' not found',
                    ],
                    404
                );
            }
        });
    })->create();
