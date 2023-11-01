<?php

namespace Mferrara\Siren;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Mferrara\Siren\Commands\SirenCommand;

class SirenServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('server-siren')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_server-siren_table')
            ->hasCommand(SirenCommand::class);
    }
}
