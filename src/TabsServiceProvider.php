<?php

namespace DKulyk\Nova;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class TabsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(ServingNova::class, function () {
            Nova::script('dkulyk-nova-tabs', dirname(__DIR__) . '/dist/js/tabs.js');
            Nova::style('dkulyk-nova-tabs', dirname(__DIR__) . '/dist/css/tabs.css');
        });
    }
}
