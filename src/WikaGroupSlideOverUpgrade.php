<?php

namespace WikaGroup\LivewireSlideOvers;

use Livewire\Features\SupportConsoleCommands\Commands\Upgrade\UpgradeStep;
use Livewire\Features\SupportConsoleCommands\Commands\UpgradeCommand;

class WikaGroupSlideOverUpgrade extends UpgradeStep
{
    public function handle(UpgradeCommand $console, \Closure $next)
    {
        $this->interactiveReplacement(
            console: $console,
            title: 'Update PHP namespaces.',
            before: 'namespace WireComponents\\LivewireSlideOvers',
            after: 'namespace WikaGroup\\LivewireSlideOvers',
            pattern: '/namespace\s+WireComponents\\\\LivewireSlideOvers;/',
            replacement: 'namespace WikaGroup\\LivewireSlideOvers',
            directories: ['app', 'src', 'tests']
        );

        $this->interactiveReplacement(
            console: $console,
            title: 'Update use statements referencing the old namespace.',
            before: 'use WireComponents\\LivewireSlideOvers\\SlideOverComponent;',
            after: 'use WikaGroup\\LivewireSlideOvers\\SlideOverComponent;',
            pattern: '/use\s+WireComponents\\\\LivewireSlideOvers\\\\/',
            replacement: 'use WikaGroup\\LivewireSlideOvers\\',
            directories: ['src', 'app', 'tests']
        );
    }
}
