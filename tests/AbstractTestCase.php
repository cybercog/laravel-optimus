<?php

/*
 * This file is part of Laravel Optimus.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Optimus\Tests;

use Cog\Optimus\Providers\OptimusServiceProvider;
use GrahamCampbell\TestBench\AbstractPackageTestCase;

/**
 * Class AbstractTestCase.
 *
 * @package Cog\Optimus\Tests
 */
abstract class AbstractTestCase extends AbstractPackageTestCase
{
    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return OptimusServiceProvider::class;
    }
}
