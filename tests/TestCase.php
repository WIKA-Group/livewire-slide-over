<?php

declare(strict_types=1);

namespace WikaGroup\LivewireSlideOvers\Tests;

use Livewire\LivewireServiceProvider;
use WikaGroup\LivewireSlideOvers\LivewireSlideOverServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            LivewireSlideOverServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:z1qfUazFM1lzfPy5sFcm8oykb2pQeS0/wuX79GdL3zI=');
    }
}
