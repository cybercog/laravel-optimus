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

namespace Cog\Tests\Laravel\Optimus\Providers;

use Cog\Laravel\Optimus\OptimusFactory;
use Cog\Laravel\Optimus\OptimusManager;
use Cog\Tests\Laravel\Optimus\AbstractTestCase;
use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use Jenssegers\Optimus\Optimus;

final class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function testOptimusFactoryIsInjectable(): void
    {
        $this->assertIsInjectable(OptimusFactory::class);
    }

    public function testOptimusManagerIsInjectable(): void
    {
        $this->assertIsInjectable(OptimusManager::class);
    }

    public function testBindings(): void
    {
        $this->assertIsInjectable(Optimus::class);

        $original = $this->app['optimus.connection'];
        $this->app['optimus']->reconnect();
        $new = $this->app['optimus.connection'];

        $this->assertNotSame($original, $new);
        $this->assertEquals($original, $new);
    }
}
