<?php

namespace WireComponents\LivewireSlideOvers\Tests;

use Livewire\Livewire;
use WireComponents\LivewireSlideOvers\Tests\Components\DemoSlideOver;

class LivewireModalComponentTest extends TestCase
{
    protected function getComponentName(string $class): string
    {
        if (class_exists(\Livewire\Mechanisms\ComponentRegistry::class)) {
            return app(\Livewire\Mechanisms\ComponentRegistry::class)
                ->getName($class);
        }

        return app('livewire.finder')->normalizeName($class);
    }

    public function test_close_panel(): void
    {
        Livewire::test(DemoSlideOver::class)
            ->call('closePanel')
            ->assertDispatched('closePanel', force: false, skipPreviousPanels: 0, destroySkipped: false);
    }

    public function test_force_close_panel(): void
    {
        Livewire::test(DemoSlideOver::class)
            ->call('forceClose')
            ->call('closePanel')
            ->assertDispatched('closePanel', force: true, skipPreviousPanels: 0, destroySkipped: false);
    }

    public function test_modal_skipping(): void
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

    public function test_slide_over_emitting(): void
    {
        Livewire::test(DemoSlideOver::class)
            ->call('closePanelWithEvents', [
                'someEvent',
            ])
            ->assertDispatched('someEvent');

        $name = $this->getComponentName(DemoSlideOver::class);

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
