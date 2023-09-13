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

use Cog\Laravel\Optimus\OptimusFactory;
use Jenssegers\Optimus\Optimus;

final class OptimusFactoryTest extends AbstractTestCase
{
    public function testMakeStandard(): void
    {
        $factory = $this->getOptimusFactory();

        $return = $factory->make([
            'prime' => 'your-prime-integer',
            'inverse' => 'your-inverse-integer',
            'random' => 'your-random-integer',
        ]);

        $this->assertInstanceOf(Optimus::class, $return);
    }

    protected function getOptimusFactory(): OptimusFactory
    {
        return new OptimusFactory();
    }
}
