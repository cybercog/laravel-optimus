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

namespace Cog\Tests\Laravel\Optimus\Unit\Providers;

use Cog\Laravel\Optimus\OptimusFactory;
use Cog\Laravel\Optimus\OptimusManager;
use Cog\Laravel\Optimus\Providers\OptimusServiceProvider;
use Cog\Tests\Laravel\Optimus\AbstractTestCase;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Optimus\Optimus;

final class ServiceProviderTest extends AbstractTestCase
{
    public function testIsAServiceProvider(): void
    {
        $this->assertTrue(is_subclass_of(OptimusServiceProvider::class, ServiceProvider::class));
    }

    public function testProvides(): void
    {
        $provider = new OptimusServiceProvider($this->app);

        $this->assertIsArray($provider->provides());
    }

    public function testOptimusFactoryIsInjectable(): void
    {
        $this->assertInstanceOf(OptimusFactory::class, $this->app->make(OptimusFactory::class));
    }

    public function testOptimusManagerIsInjectable(): void
    {
        $this->assertInstanceOf(OptimusManager::class, $this->app->make(OptimusManager::class));
    }

    public function testBindings(): void
    {
        $this->assertInstanceOf(Optimus::class, $this->app->make(Optimus::class));

        $original = $this->app['optimus.connection'];
        $this->app['optimus']->reconnect();
        $new = $this->app['optimus.connection'];

        $this->assertNotSame($original, $new);
        $this->assertEquals($original, $new);
    }
}
