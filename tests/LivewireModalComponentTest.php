<?php

namespace WireComponents\LivewireSlideOvers\Tests;

use Livewire\Livewire;
use Livewire\Mechanisms\ComponentRegistry;
use WireComponents\LivewireSlideOvers\Tests\Components\DemoSlideOver;

class LivewireModalComponentTest extends TestCase
{
    public function testClosePanel(): void
    {
        Livewire::test(DemoSlideOver::class)
            ->call('closePanel')
            ->assertDispatched('closePanel', force: false, skipPreviousPanels: 0, destroySkipped: false);
    }

    public function testForceClosePanel(): void
    {
        Livewire::test(DemoSlideOver::class)
            ->call('forceClose')
            ->call('closePanel')
            ->assertDispatched('closePanel', force: true, skipPreviousPanels: 0, destroySkipped: false);
    }

    public function testModalSkipping(): void
    {
        Livewire::test(DemoSlideOver::class)
            ->call('skipPreviousPanels', 5)
            ->call('closePanel')
            ->assertDispatched('closePanel', force: false, skipPreviousPanels: 5, destroySkipped: false);

        Livewire::test(DemoSlideOver::class)
            ->call('skipPreviousPanels')
            ->call('closePanel')
            ->assertDispatched('closePanel', force: false, skipPreviousPanels: 1, destroySkipped: false);

        Livewire::test(DemoSlideOver::class)
            ->call('skipPreviousPanels')
            ->call('destroySkippedPanels')
            ->call('closePanel')
            ->assertDispatched('closePanel', force: false, skipPreviousPanels: 1, destroySkipped: true);
    }

    public function testSlideOverEmitting(): void
    {
        Livewire::test(DemoSlideOver::class)
            ->call('closePanelWithEvents', [
                'someEvent',
            ])
            ->assertDispatched('someEvent');
        
        $name = app(ComponentRegistry::class)->getName(DemoSlideOver::class);

        Livewire::test(DemoSlideOver::class)
            ->call('closePanelWithEvents', [
                $name => 'someEvent',
            ])
            ->assertDispatched('someEvent');

        Livewire::test(DemoSlideOver::class)
            ->call('closePanelWithEvents', [
                ['someEventWithParams', ['param1', 'param2']],
            ])
            ->assertDispatched('someEventWithParams', 'param1', 'param2');
        
        Livewire::test(DemoSlideOver::class)
            ->call('closePanelWithEvents', [
                $name => ['someEventWithParams', ['param1', 'param2']],
            ])
            ->assertDispatched('someEventWithParams', 'param1', 'param2');
    }
}
