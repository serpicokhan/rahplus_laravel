<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckStatus;
use App\Http\Middleware\MaintenanceMode;
use App\Http\Middleware\RedirectIfAdmin;
use App\Http\Middleware\RedirectIfNotAdmin;
use App\Http\Middleware\RegistrationStep;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\LanguageMiddleware;
use App\Http\Middleware\ActiveTemplateMiddleware;
use App\Http\Middleware\Demo;
use App\Http\Middleware\DeveloperToken;
use App\Http\Middleware\DriverVerification;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TokenPermission;
use App\Http\Middleware\VerifyCsrfToken;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function () {
            Route::namespace('App\Http\Controllers')->group(function () {
                Route::prefix('api')
                    ->middleware(['api', 'maintenance', 'developer.token'])
                    ->group(base_path('routes/api.php'));
                Route::middleware(['web'])
                    ->namespace('Admin')
                    ->prefix('admin')
                    ->name('admin.')
                    ->group(base_path('routes/admin.php'));
                Route::middleware(['web', 'maintenance'])
                    ->namespace('Gateway')
                    ->prefix('ipn')
                    ->name('ipn.')
                    ->group(base_path('routes/ipn.php'));
                Route::middleware(['web', 'maintenance'])->prefix('user')->group(base_path('routes/user.php'));
                Route::middleware(['web', 'maintenance'])->prefix('driver')->group(base_path('routes/driver.php'));
                Route::middleware(['web', 'maintenance'])->group(base_path('routes/web.php'));
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('web', [
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            SubstituteBindings::class,
            LanguageMiddleware::class,
            ActiveTemplateMiddleware::class,
            SubstituteBindings::class,
            VerifyCsrfToken::class,
        ]);
        $middleware->alias([
            'admin'       => RedirectIfNotAdmin::class,
            'admin.guest' => RedirectIfAdmin::class,

            'maintenance'           => MaintenanceMode::class,
            'registration.complete' => RegistrationStep::class,
            'demo'                  => Demo::class,
            'auth'                  => Authenticate::class,
            'token.permission'      => TokenPermission::class,
            'driver.verification'   => DriverVerification::class,
            'check.status'          => CheckStatus::class,
            'guest'                 => RedirectIfAuthenticated::class,
            'developer.token'         => DeveloperToken::class,
        ]);
        $middleware->validateCsrfTokens(
            except: ['user/deposit', 'ipn*']
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {

                //for not found
                if ($e instanceof NotFoundHttpException) {
                    return apiResponse('not_found', 'error', [$e->getMessage()], statusCode: 404);
                }

                //for authenticated 
                if ($e->getMessage() === 'Unauthenticated.') {
                    $notify[] = 'Unauthorized request';
                    return apiResponse('unauthenticated', 'error', $notify, statusCode: 401);
                }

                // return apiResponse('exception', 'error', [$e->getMessage()]);
            }
        });
    })->create();
