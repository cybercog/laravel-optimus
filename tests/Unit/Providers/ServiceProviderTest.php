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
        $this->configurePrimeNumbers();

        $this->assertIsInjectable(Optimus::class);

        $original = $this->app['optimus.connection'];
        $this->app['optimus']->reconnect();
        $new = $this->app['optimus.connection'];

        $this->assertNotSame($original, $new);
        $this->assertEquals($original, $new);
    }

    protected function configurePrimeNumbers(): void
    {
        config()->set('optimus.connections', [
            'main' => [
                'prime' => 1490261603,
                'inverse' => 1573362507,
                'random' => 1369544188,
            ],
            'custom' => [
                'prime' => 1770719809,
                'inverse' => 1417283009,
                'random' => 508877541,
            ],
        ]);
    }
}
