<?php

namespace WikaGroup\LivewireSlideOver\Tests;

use Livewire\Livewire;
use WikaGroup\LivewireSlideOver\Position;
use WikaGroup\LivewireSlideOver\SlideOver;
use WikaGroup\LivewireSlideOver\Tests\Components\DemoSlideOver;
use WikaGroup\LivewireSlideOver\Tests\Components\InvalidSlideOver;

class LivewireSlideOverTest extends TestCase
{
    public function testOpenSlideOverEventListener(): void
    {
        // Demo slide over component
        Livewire::component('demo-slide-over', DemoSlideOver::class);

        // Event attributes
        $component = 'demo-slide-over';
        $arguments = ['user' => 1, 'number' => 42, 'message' => 'Hello World'];
        $panelAttributes = [
            'hello' => 'world',
            'closeOnEscape' => true,
            'maxWidth' => '2xl',
            'maxWidthClass' => 'sm:max-w-md md:max-w-xl lg:max-w-2xl',
            'closeOnClickAway' => true,
            'closeOnEscapeIsForceful' => true,
            'dispatchCloseEvent' => false,
            'destroyOnClose' => false,
            'position' => Position::Right,
        ];

        // Demo slide over unique identifier
        $id = md5($component . serialize($arguments));

        Livewire::test(SlideOver::class)
            ->dispatch('openPanel', component: $component, arguments: $arguments, panelAttributes: $panelAttributes)
            // Verify component is added to $components
            ->assertSet('components', [
                $id => [
                    'name' => $component,
                    'arguments' => $arguments,
                    'panelAttributes' => $panelAttributes,
                ],
            ])
            // Verify component is set to active
            ->assertSet('activeComponent', $id)
            // Verify event is emitted to client
            ->assertDispatched('activePanelComponentChanged', id: $id)
            // Verif if component attribute 'message' is visible
            ->assertSee(['Hello World', 1, '42']);
    }

    public function testDestroyComponentEventListener(): void
    {
        // Demo slide over component
        Livewire::component('demo-slide-over', DemoSlideOver::class);

        $component = 'demo-slide-over';
        $arguments = ['message' => 'Foobar'];
        $panelAttributes = [
            'hello' => 'world',
            'closeOnEscape' => true,
            'maxWidth' => '2xl',
            'maxWidthClass' => 'sm:max-w-md md:max-w-xl lg:max-w-2xl',
            'closeOnClickAway' => true,
            'closeOnEscapeIsForceful' => true,
            'dispatchCloseEvent' => false,
            'destroyOnClose' => false,
            'position' => Position::Right,
        ];

        // Demo slide over unique identifier
        $id = md5($component . serialize($arguments));

        Livewire::test(SlideOver::class)
            ->dispatch('openPanel', component: $component, arguments: $arguments, panelAttributes: $panelAttributes)
            ->assertSet('components', [
                $id => [
                    'name' => $component,
                    'arguments' => $arguments,
                    'panelAttributes' => $panelAttributes,
                ],
            ])
            ->dispatch('destroyComponent', $id)
            ->assertSet('components', []);
    }

    public function testSlideOverReset(): void
    {
        Livewire::component('demo-slide-over', DemoSlideOver::class);

        Livewire::test(SlideOver::class)
            ->dispatch('openPanel', component: 'demo-slide-over', arguments: ['message' => 'Test'])
            ->assertNotSet('activeComponent', null)
            ->assertNotSet('components', [])
            ->call('resetState')
            // Verify properties are reset
            ->assertSet('activeComponent', null)
            ->assertSet('components', []);
    }

    public function testIfExceptionIsThrownIfSlideOverDoesNotImplementContract(): void
    {
        $component = InvalidSlideOver::class;
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("[{$component}] does not implement [WikaGroup\LivewireSlideOver\Contracts\PanelContract] interface.");

        Livewire::component('invalid-slide-over', $component);
        Livewire::test(SlideOver::class)->dispatch('openPanel', component: 'invalid-slide-over');
    }
}
