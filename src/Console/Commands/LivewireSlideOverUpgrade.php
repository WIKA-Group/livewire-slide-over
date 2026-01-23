<?php

namespace WikaGroup\LivewireSlideOver\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LivewireSlideOverUpgrade extends Command
{
    protected $signature = 'livewire-slide-over:upgrade';

    protected $description = 'Upgrade Livewire Slide Overs to support the latest version';

    private int $recordsProcessed = 0;

    private array $directories = ['app', 'config', 'resources', 'tests'];

    public function handle(): int
    {
        $this->info('Upgrade Livewire slide overs...');
        $this->newLine();

        foreach ($this->directories as $directory) {
            if (!File::exists(base_path($directory))) {
                continue;
            }

            foreach (File::allFiles(base_path($directory)) as $file) {
                if (!Str::endsWith($file->getFilename(), '.php')
                    && !Str::endsWith($file->getFilename(), '.blade.php')) {
                    continue;
                }

                $content = File::get($file->getPathname());

                if (!Str::contains($content, 'WireComponents\\LivewireSlideOvers')) {
                    continue;
                }

                $updated = Str::replace(
                    'WireComponents\\LivewireSlideOvers',
                    'WikaGroup\\LivewireSlideOver',
                    $content);

                if ($updated === $content) {
                    continue;
                }

                File::put($file->getPathname(), $updated);

                $this->info(
                    sprintf(
                        'File %s updated successfully.',
                        $file->getFilename()));

                $this->recordsProcessed++;
            }
        }

        $this->newLine();
        $this->info($this->recordsProcessed . ' file(s) processed.');

        return self::SUCCESS;
    }
}
