# Another Laravel Nova Tabs Package
[![Latest Version on Github](https://img.shields.io/packagist/v/dkulyk/nova-tabs.svg?style=flat)](https://packagist.org/packages/dkulyk/nova-tabs)
[![Total Downloads](https://img.shields.io/packagist/dt/dkulyk/nova-tabs.svg?style=flat)](https://packagist.org/packages/dkulyk/nova-tabs)
[![Become a Patron!](https://img.shields.io/badge/become-a_patron!-red.svg?logo=patreon&style=flat)](https://www.patreon.com/bePatron?u=16285116)

1. [Installation](#user-content-installation)
2. [Usage](#user-content-usage)
    1. [Tabs Panel](#user-content-tabs-panel)
    2. [Tabs Panel with Toolbar](#user-content-tabs-panel-with-toolbar)
    3. [Relationship Tabs](#user-content-relationship-tabs)
    4. [Combine Fields and Relations in Tabs](#user-content-combine-fields-and-relations-in-tabs)
3. [Customization](#user-content-customization)
4. [Difference with eminiarts/nova-tabs](#user-content-differenece-with-eminiartsnova-tabs)

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require dkulyk/nova-tabs
```

## Usage

### Tabs Panel

![image](https://user-images.githubusercontent.com/3426944/50060698-7835ec00-0197-11e9-8b9c-c7f1e67400db.png)

You can group Fields of a Resource into Tabs.

```php
// in app/Nova/Resource.php

use DKulyk\Nova\Tabs;

public function fields()
{
    return [
        
        // ...
        
        new Tabs('Tabs', [
            new Panel('Balance', [
                Number::make('Balance', 'balance')->onlyOnDetail(),
                Number::make('Total', 'total')->onlyOnDetail(),
            ]),
            'Other Info' => [
                Number::make('Paid To Date', 'paid_to_date')->onlyOnDetail(),
            ],
        ]),
        
        // ...
        
    ];
}
```

### Tabs Panel with Toolbar

If you are only using a Tabs without another default Panel, you can set the third argument `showToolbar` to `true` like in Panel.

![image](https://user-images.githubusercontent.com/3426944/50448780-608efe00-0923-11e9-9d55-3dc3d8d896e1.png)


```php
// in app/Nova/Resource.php

use DKulyk\Nova\Tabs;

public function fields(Request $request)
{
    return [
        (new Tabs('Contact Details', [
            'Address' => [
                ID::make('Id', 'id')->rules('required'),
                Text::make('Email', 'email')->sortable(),
                Text::make('Phone', 'phone')->sortable(),
            ],

            'Relations' => [
                BelongsTo::make('User'),
                MorphTo::make('Contactable')->types([
                    Client::class,
                    Invoice::class,
                ]),
            ]
        ]))->withToolbar(),
    ];
}
```

### Relationship Tabs

![image](https://user-images.githubusercontent.com/3426944/50060715-a3b8d680-0197-11e9-8f98-1cac8cf3fd83.png)

You can also group Relations into Tabs.

```php
// in app/Nova/Resource.php

use DKulyk\Nova\Tabs;

public function fields(Request $request)
{
    return [

        // ...

        new Tabs('Relations', [
            HasMany::make('Invoices'),
            HasMany::make('Notes'),
            HasMany::make('Contacts')
        ]),

        // ...

    ];
}
```

### Combine Fields and Relations in Tabs

![image](https://user-images.githubusercontent.com/3426944/51089909-b3b2de80-1774-11e9-9100-d323accda7db.png)

![image](https://user-images.githubusercontent.com/3426944/51089905-aa297680-1774-11e9-9611-4446ca13ab4a.png)


```php
use DKulyk\Nova\Tabs;

public function fields(Request $request)
{
    return [
        (new Tabs(__('Client Custom Details'), [
            new Panel(__('Details'), [
                    ID::make('Id', 'id')->rules('required')->hideFromIndex(),
                    Text::make('Name', 'name'),
            ]),
            HasMany::make('Invoices')
        ])
    ];
}
```

## Customization

By default, the Tabs component moves the search input and the create button to the tabs. If you have a lot of tabs, you can move them back down to its own line:

```php
// in app/Nova/Resource.php

use DKulyk\Nova\Tabs;

public function fields(Request $request)
{
    return [

        // ...

        (new Tabs('Relations', [
            HasMany::make('Invoices')
        ]))->defaultSearch(true),

        // ...

    ];
}
```

Set `->defaultSearch(true)` to revert it to its default.

![image](https://user-images.githubusercontent.com/3426944/50060732-dbc01980-0197-11e9-8f0c-6014132539a2.png)


### Differenece with [eminiarts/nova-tabs](https://github.com/eminiarts/nova-tabs)

1. No need to use trait.
2. Fields passed through a standard panel(standard authorization and visibility behavior).
3. Nested Panels and Listable fields become a new tabs.
4. Relations will loaded only when Tab will be open.

