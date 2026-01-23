<?php

namespace WikaGroup\LivewireSlideOver\Tests\Components;

use WikaGroup\LivewireSlideOver\SlideOverComponent;

class DemoSlideOver extends SlideOverComponent
{
    public $user;

    public $number;

    public $message;

    public function render()
    {
        return <<<blade
            <div>
                {$this->user} says:
                {$this->message} + {$this->number}
            </div>
        blade;
    }
}
