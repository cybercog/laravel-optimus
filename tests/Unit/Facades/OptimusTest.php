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

namespace Cog\Tests\Laravel\Optimus\Unit\Facades;

use Cog\Laravel\Optimus\Facades\Optimus;
use Cog\Laravel\Optimus\OptimusManager;
use Cog\Tests\Laravel\Optimus\AbstractTestCase;
use Illuminate\Support\Facades\Facade;
use ReflectionMethod;

final class OptimusTest extends AbstractTestCase
{
    public function testIsAFacade(): void
    {
        $this->assertTrue(is_subclass_of(Optimus::class, Facade::class));
    }

    public function testFacadeAccessor(): void
    {
        $method = new ReflectionMethod(Optimus::class, 'getFacadeAccessor');

        $this->assertSame('optimus', $method->invoke(null));
    }

    public function testFacadeRoot(): void
    {
        $this->assertInstanceOf(OptimusManager::class, Optimus::getFacadeRoot());
    }
}
