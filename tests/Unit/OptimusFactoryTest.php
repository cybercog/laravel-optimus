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

namespace Cog\Tests\Laravel\Optimus\Unit;

use Cog\Laravel\Optimus\OptimusFactory;
use Cog\Tests\Laravel\Optimus\AbstractTestCase;
use Jenssegers\Optimus\Optimus;

final class OptimusFactoryTest extends AbstractTestCase
{
    public function testMakeStandard(): void
    {
        $instance = (new OptimusFactory())->make([
            'prime' => 0,
            'inverse' => 1,
            'random' => 2,
        ]);

        $this->assertInstanceOf(Optimus::class, $instance);
    }
}
