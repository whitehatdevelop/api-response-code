<?php

namespace Spatie\Skeleton;

use Illuminate\Support\ServiceProvider;
use Spatie\Skeleton\Commands\SkeletonCommand;

class ApiResponseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
//            $this->publishes([
//                __DIR__ . '/../config/skeleton.php' => config_path('skeleton.php'),
//            ], 'config');
//
            $migrationFileName = '2020_12_05_113446_create_operation_responses_table.php';
            if (!$this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        }
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'skeleton');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/skeleton.php', 'skeleton');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }
        return false;
    }
}