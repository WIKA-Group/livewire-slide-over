<?php

namespace WikaGroup\LivewireSlideOver;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LivewireSlideOverUpgrade
{
    private int $recordsProcessed = 0;

    public static function handle(string $projectRoot): void
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($projectRoot . '/app')
        );

        foreach ($files as $file) {
            if (!$file->isFile()) {
                continue;
            }

            self::processFile($file);
        }

        echo self::$recordsProcessed . " file(s) processed.\n\n";

        echo "Livewire slide over namespaces updated.\n";
    }

    public function processFile($file): void
    {
        $content = file_get_contents($file->getPathname());

        $content = str_replace(
            'WireComponents\\LivewireSlideOvers\\',
            'WikaGroup\\LivewireSlideOver\\',
            $content);

        file_put_contents($file->getPathname(), $content);

        $this->recordsProcessed++;
    }
}
