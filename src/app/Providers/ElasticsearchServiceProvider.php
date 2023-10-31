<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton('elasticsearch', function () {
            $hosts = [
                sprintf(
                    '%s://%s:%s@%s:%s',
                    'http',
                    config('elasticsearch.username'),
                    config('elasticsearch.password'),
                    config('elasticsearch.host'),
                    config('elasticsearch.port')
                )
            ];

            return ClientBuilder::create()
                ->setHosts($hosts)
                ->build();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
