<?php

namespace App\Providers;

use App\Http\Middleware\CheckTokenExpiryForAdmin;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // DB::listen(function ($query) {
        // 	// Get the current database connection name and database name
        // 	$connectionName = DB::getDefaultConnection();
        // 	$databaseName = DB::connection()->getDatabaseName();

        // 	// Log the connection details
        // 	Log::info('Executed Query: ' . $query->sql);
        // 	Log::info('Bindings: ' . json_encode($query->bindings));
        // 	Log::info('Time taken: ' . $query->time . 'ms');

        // 	Log::info("Connected to database: {$databaseName} using connection: {$connectionName}");
        // });

        Passport::tokensExpireIn(Carbon::now()->addSeconds(30));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        $this->registerMiddleware();
    }

    protected function registerMiddleware()
    {
        // Register middleware for token expiry check
        Route::middlewareGroup('check.token.expiry.admin', [
            CheckTokenExpiryForAdmin::class,
        ]);
    }
}
