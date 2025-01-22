<?php

declare(strict_types=1);

namespace Inisiatif\Distribution\Financings;

use FromHome\ModelUpload\ModelUpload;
use Inisiatif\Distribution\Financings\Models\Financing;
use Inisiatif\Distribution\Financings\ModelUploads\FinancingProcessor;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class DistributionFinancingServiceProvider extends PackageServiceProvider
{
    public function bootingPackage(): void
    {
        ModelUpload::registerRecordProcessors([
            Financing::class => FinancingProcessor::class,
        ]);
    }

    public function configurePackage(Package $package): void
    {
        $package->name('distribution-financings')
            ->hasConfigFile('financing')
            ->hasRoute('api')
            ->hasMigration('create_distribution_financings_table');
    }

    public function registeringPackage(): void
    {
        if ($this->app->runningUnitTests() && $this->app->runningInConsole()) {
            $this->loadMigrationsFrom('../../migrations');
            $this->loadMigrationsFrom('../../migrations/testing');
        }
    }
}
