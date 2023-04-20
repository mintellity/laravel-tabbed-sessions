<?php

namespace Mintellity\TabbedSession;

use Mintellity\TabbedSession\Entities\Tab;
use Mintellity\TabbedSession\Entities\TabSession;
use Mintellity\TabbedSession\Routing\TabbedUrlGenerator;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TabbedSessionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('tabbed-session')
            ->hasConfigFile()
            ->hasAssets();
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
    }
}
