<?php

namespace WikaGroup\LivewireSlideOver;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LivewireSlideOverUpgrade
{
    private array $directories = [
        'app',
        'config',
    ];

    private int $recordsProcessed = 0;

    public function handle(string $projectRoot): void
    {
        foreach ($this->directories as $directory) {
            $dir = $projectRoot . '/' . $directory;

            if (!is_dir($dir)) {
                continue;
            }

            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dir)
            );

            foreach ($files as $file) {
                if (!$file->isFile()) {
                    continue;
                }

                self::processFile($file);
            }
        }

        echo $this->recordsProcessed . " file(s) processed.\n\n";

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
