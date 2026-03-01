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

namespace Cog\Tests\Laravel\Optimus;

use Cog\Laravel\Optimus\Providers\OptimusServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class AbstractTestCase extends TestCase
{
    public static $latestResponse;

    protected function getPackageProviders($app): array
    {
        return [
            OptimusServiceProvider::class,
        ];
    }
}
