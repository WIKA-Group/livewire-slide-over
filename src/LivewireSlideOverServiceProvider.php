<?php

namespace WikaGroup\LivewireSlideOver;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use WikaGroup\LivewireSlideOver\Console\Commands\LivewireSlideOverUpgrade;

final class LivewireSlideOverServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('livewire-slide-over')
            ->hasConfigFile()
            ->hasCommands([
                LivewireSlideOverUpgrade::class,
            ])
            ->hasViews();
    }

    public function bootingPackage(): void
    {
        Livewire::component('slide-over', SlideOver::class);
    }
}
