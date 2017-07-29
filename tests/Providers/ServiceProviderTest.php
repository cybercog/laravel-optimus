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

namespace Cog\Laravel\Optimus\Tests;

use Cog\Laravel\Optimus\OptimusFactory;
use Cog\Laravel\Optimus\OptimusManager;
use Jenssegers\Optimus\Optimus;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

/**
 * Class ServiceProviderTest.
 *
 * @package Cog\Laravel\Optimus\Tests\Providers
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testOptimusFactoryIsInjectable()
    {
        $this->assertIsInjectable(OptimusFactory::class);
    }

    public function testOptimusManagerIsInjectable()
    {
        $this->assertIsInjectable(OptimusManager::class);
    }

    public function testBindings()
    {
        $this->assertIsInjectable(Optimus::class);

        $original = $this->app['optimus.connection'];
        $this->app['optimus']->reconnect();
        $new = $this->app['optimus.connection'];

        $this->assertNotSame($original, $new);
        $this->assertEquals($original, $new);
    }
}
