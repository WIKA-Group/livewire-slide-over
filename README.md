<p align="center">
    <a href="https://laravel.com">
        <img alt="Laravel v10.x" src="https://img.shields.io/badge/Laravel-v10.x-FF2D20">
    </a>
    <a href="https://laravel.com">
        <img alt="Laravel v11.x" src="https://img.shields.io/badge/Laravel-v11.x-FF2D20">
    </a>
    <a href="https://packagist.org/packages/batnieluyo/livewire-slide-overs">
        <img src="https://img.shields.io/packagist/dt/batnieluyo/livewire-slide-overs" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravelcm/livewire-slide-overs">
        <img src="https://img.shields.io/packagist/v/laravelcm/livewire-slide-overs" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravelcm/livewire-slide-overs">
        <img src="https://img.shields.io/packagist/l/laravelcm/livewire-slide-overs" alt="License">
    </a>
</p>

# Livewire Slide over Panel

Slide Over Panel is a Livewire component that provides drawers (slide overs) that support multiple children while maintaining state.
This package is fork of [laravelcm/livewire-slide-overs](https://github.com/laravelcm/livewire-slide-overs), a livewire component that renders slide over with state management on livewire.


### Installation

To get started, require the package via Composer

```shell
composer require batnieluyo/livewire-slide-over
```

### Usage
Add the Livewire directive @livewire('slide-over-panel') directive to your master layout.

```blade
<html>
<body>
    <!-- content -->

    @livewire('slide-over-panel')
</body>
</html>
```

## Creating a Slide Over
You can run `php artisan make:livewire ShoppingCart` to make the initial Livewire component. Open your component class and make sure it extends the `SlideOverComponent` class:

```php
<?php

namespace App\Livewire;

use WireComponents\LivewireSlideOvers\SlideOverComponent;

class ShoppingCart extends SlideOverComponent
{
    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
```

## Opening a Slide over
To open a slide over you will need to dispatch an event. To open the `ShoppingCart` slide over for example:

```html
<!-- Outside of any Livewire component -->
<button onclick="Livewire.dispatch('openPanel', { component: 'shopper-cart' })">View cart</button>

<!-- Inside existing Livewire component -->
<button wire:click="$dispatch('openPanel', { component: 'shopping-cart' })">View cart</button>

<!-- Taking namespace into account for component Shop/Actions/ShoppingCart -->
<button wire:click="$dispatch('openPanel', { component: 'shop.actions.shopping-cart' })">View cart</button>
```

### TailwindCSS
The base modal is made with TailwindCSS. If you use a different CSS framework I recommend that you publish the modal template and change the markup to include the required classes for your CSS framework.

```
php artisan vendor:publish --tag=livewire-slide-over-views
```


### Building Tailwind CSS for production
To purge the classes used by the package, add the following lines to your purge array in tailwind.config.js:

```
'./vendor/livewire-slide-overs/resources/views/*.blade.php',
'./storage/framework/views/*.php',
```

Because some classes are dynamically build you should add some classes to the purge safelist so your tailwind.config.js should look something like this:

```js
module.exports = {
  purge: {
    content: [
      './vendor/livewire-slide-overs/resources/views/*.blade.php',
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
    ],
    options: {
      safelist: {
            pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
            variants: ['sm', 'md', 'lg', 'xl', '2xl']
        } 
    }
  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
```

#### For TailwindCSS 3x

```js
export default {
  content: [
    './vendor/livewire-slide-overs/resources/views/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
  ],
  safelist: [
    {
      pattern: /max-w-(sm|md|lg|xl|2xl|3xl|4xl|5xl|6xl|7xl)/,
      variants: ['sm', 'md', 'lg', 'xl', '2xl']
    }
  ],
  // other options
}
```

### Configuration
You can customize the Modal via the wire-elements-modal.php config file. This includes some additional options like including CSS if you don't use TailwindCSS for your application, as well as the default modal properties.

To publish the config run the vendor:publish command:

```
php artisan vendor:publish --tag=livewire-slide-over-config
```

```php
<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Include CSS
    |--------------------------------------------------------------------------
    |
    | The modal uses TailwindCSS, if you don't use TailwindCSS you will need
    | to set this parameter to true. This includes the modern-normalize css.
    |
    */
    'include_css' => true,

    /*
    |--------------------------------------------------------------------------
    | Include JS
    |--------------------------------------------------------------------------
    |
    | Livewire UI will inject the required Javascript in your blade template.
    | If you want to bundle the required Javascript you can set this to false
    | and add `require('vendor/wire-elements/modal/resources/js/modal');`
    | to your script bundler like webpack.
    |
    */
    'include_js' => true,
    
    /*
    |--------------------------------------------------------------------------
    | Default Slide Over Position
    |--------------------------------------------------------------------------
    | Configure which way the slide-over will open
    |
    | Available slide overs position
    | Position::Right, Position::Left, Position::Bottom
    |
    */

    'default_position' => \Laravelcm\LivewireSlideOvers\Position::Right,

    /*
    |--------------------------------------------------------------------------
    | Slide Over Component Defaults
    |--------------------------------------------------------------------------
    |
    | Configure the default properties for a slide-over component.
    |
    | Supported slide_over_max_width
    | 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    */

    'component_defaults' => [
        'slide_over_max_width' => 'xl',
        'close_slide_over_on_click_away' => true,
        'close_slide_over_on_escape' => true,
        'close_slide_over_on_escape_is_forceful' => true,
        'dispatch_close_event' => false,
        'destroy_on_close' => false,
    ],

];
```

### Test
wip..

```shell
composer test
```

## Credits
- [laravelcm](https://github.com/laravelcm)
- [Philo Hermans](https://github.com/philoNL)
- [All Contributors](../../contributors)

## License
Livewire Slide Over is open-sourced software licensed under the [MIT license](LICENSE.md).
