<?php

namespace WikaGroup\LivewireSlideOver;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LivewireSlideOverUpgrade
{
    public static function run(string $projectRoot): void
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($projectRoot . '/app')
        );

        foreach ($files as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $content = file_get_contents($file->getPathname());

            $content = str_replace(
                'WireComponents\\LivewireSlideOvers\\',
                'WikaGroup\\LivewireSlideOver\\',
                $content);

            file_put_contents($file->getPathname(), $content);
        }

        echo "Livewire slide over namespaces updated\n";
    }
}
