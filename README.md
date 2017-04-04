# Laravel Memory Auth Provider

A In Memory User Auth Provider for Laravel 5.1+


## Installation

You can install it using composer:

`composer require tomgrohl/laravel-memory-auth-provider`


## Configuration

### 1 .Add service provider

Add the following to your `providers` in the `app` config

```php
<?php

return [
    
    //...
    
    'providers' => [
        //...    
        'Tomgrohl\Laravel\Auth\AuthServiceProvider',
        
        // OR
        \Tomgrohl\Laravel\Auth\AuthServiceProvider::class,
    ]
    
    
];

```

### 2. Setup config

In the `auth` config you will need to set the driver:

```
    'driver' => 'memory',
```

Add also setup your in memory users:

```
    'memory' => [
        'users' => [
    
            'admin' => [
                'id' => 1,
                'password' => '$2y$10$Mfusxb1546MFxQ4A1s4GE.OF/gFuI8Y6Hw9xnlZeiHtjDl0/pnXPK',
            ],
        ],
    ],
```
