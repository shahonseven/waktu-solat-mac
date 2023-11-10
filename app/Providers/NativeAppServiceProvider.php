<?php

namespace App\Providers;

use Native\Laravel\Contracts\ProvidesPhpIni;
use Native\Laravel\Facades\MenuBar;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {
        MenuBar::create()
            // ->label(__('Prayer Time'))
            ->alwaysOnTop(true)
            ->height(340)
            ->width(400);
    }

    /**
     * Return an array of php.ini directives to be set.
     *
     * @return array<mixed>
     */
    public function phpIni(): array
    {
        return [
        ];
    }
}
