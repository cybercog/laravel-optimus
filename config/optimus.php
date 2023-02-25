<?php

/*
 * This file is part of Laravel Optimus.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Optimus Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    | Laravel Optimus depends on jenssegers/optimus, we need three values:
    | - A large `prime` number lower than 2147483647
    | - The `inverse` prime so that (PRIME * INVERSE) & MAXID == 1
    | - A large `random` integer lower than 2147483647
    |
    */

    'connections' => [

        'main' => [
            'prime' => 'your-prime-integer',
            'inverse' => 'your-inverse-integer',
            'random' => 'your-random-integer',
        ],

        'alternative' => [
            'prime' => 'your-prime-integer',
            'inverse' => 'your-inverse-integer',
            'random' => 'your-random-integer',
        ],

    ],

];
