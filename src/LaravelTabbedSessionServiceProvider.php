<?php

namespace Mintellity\LaravelTabbedSession;

use Mintellity\LaravelTabbedSession\Entities\FrontendSession;
use Mintellity\LaravelTabbedSession\Entities\Tab;
use Mintellity\LaravelTabbedSession\Entities\TabSession;
use Mintellity\LaravelTabbedSession\Routing\TabbedUrlGenerator;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelTabbedSessionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-tabbed-session')
            ->hasConfigFile();
    }

    public function registeringPackage(): void
    {
        parent::registeringPackage();

        $this->app->bind('url', function ($app) {
            return new TabbedUrlGenerator(
                $app['router']->getRoutes(),
                $app['request'],
                $app['config']['app.asset_url']
            );
        });
    }

    public function bootingPackage(): void
    {
        parent::bootingPackage();

        $this->app->singleton(Tab::class);
        $this->app->singleton(TabSession::class);
        $this->app->singleton(FrontendSession::class);
    }
}
