<?php

declare(strict_types=1);

namespace MobiMarket\ScrapingTool;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use MobiMarket\ScrapingTool\Entities\ApiAuth;

class ScrapingServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @deprecated
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/scraping.php'      => config_path('scraping.php'),
            __DIR__ . '/../config/scraping_solr.php' => config_path('scraping_solr.php'),
        ], 'scraping');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/scraping.php', 'scraping');
        $this->mergeConfigFrom(__DIR__ . '/../config/scraping_solr.php', 'scraping_solr');

        $this->bindRestApi(ScrapingRestApi::class, 'scraping');
        $this->bindRestApi(ScrapingSolr::class, 'scraping_solr');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [ScrapingRestApi::class, ScrapingSolr::class];
    }

    /**
     * Set up binding with prefixed config variables.
     */
    protected function bindRestApi(string $class, string $prefix): void
    {
        $this->app->singleton($class, function (Application $app) use ($prefix, $class) {
            $config = $app->make('config');

            return new $class(
                $config->get($prefix . '.api.url'),
                $config->get($prefix . '.api.timeout'),
                $config->get($prefix . '.api.should_log'),
                ApiAuth::fromArray($config->get($prefix . '.auth'))
            );
        });
    }
}
