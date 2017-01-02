<?php

/*
 * This file is part of Laravel Optimus.
 *
 * (c) CyberCog <support@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cog\Optimus\Tests;

use Jenssegers\Optimus\Optimus;
use Cog\Optimus\OptimusFactory;
use Cog\Optimus\OptimusManager;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;

/**
 * Class ServiceProviderTest.
 *
 * @package Cog\Optimus\Tests\Providers
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
