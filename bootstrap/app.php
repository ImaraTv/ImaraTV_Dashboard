<?php

use Illuminate\{
    Foundation\Application,
    Foundation\Configuration\Exceptions,
    Foundation\Configuration\Middleware,
    Http\Request
};
use Symfony\Component\HttpKernel\Exception\{
    NotFoundHttpException,
    UnauthorizedHttpException
};
use Tymon\JWTAuth\{
    Exceptions\JWTException,
    Http\Middleware\Authenticate as JWTAuthenticate
};

return Application::configure(basePath: dirname(__DIR__))
                ->withRouting(
                        web: __DIR__ . '/../routes/web.php',
                        api: __DIR__ . '/../routes/api.php',
                        apiPrefix: '/api',
                        commands: __DIR__ . '/../routes/console.php',
                        health: '/up',
                )
                ->withMiddleware(function (Middleware $middleware) {
                    $middleware->alias([
                        'jwt.auth' => JWTAuthenticate::class,
                    ]);
                })
                ->withExceptions(function (Exceptions $exceptions) {
                $exceptions->render(function(NotFoundHttpException $e,Request $request){
                     if ($request->is('api/*')) {
                            return \response()->json([
                                        'status' => 'error',
                                        'message' => $e->getMessage(),
                                            ], 404);
                        }
                });
                    $exceptions->render(function (UnauthorizedHttpException $e, Request $request) {
                        if ($request->is('api/*')) {
                            return \response()->json([
                                        'status' => 'error',
                                        'message' => $e->getMessage(),
                                            ], 401);
                        }
                    });
                    $exceptions->render(function (JWTException $e, Request $request) {
                        if ($request->is('api/*')) {
                            return \response()->json([
                                        'status' => 'error',
                                        'message' => $e->getMessage(),
                                            ], 401);
                        }
                    });
                })->create();
