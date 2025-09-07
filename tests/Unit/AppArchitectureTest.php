<?php

declare(strict_types=1);

arch()->preset()->php();
arch()->preset()->laravel()->ignoring([
    'App\Http\Controllers',
    'App\Notifications\Brevo',
]);
arch()->preset()->security();

arch()
    ->expect('App')
    ->not->toUse(['die', 'dd', 'dump']);
