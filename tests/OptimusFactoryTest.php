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

/**
 * Class OptimusFactoryTest.
 *
 * @package Cog\Optimus\Tests
 */
class OptimusFactoryTest extends AbstractTestCase
{
    public function testMakeStandard()
    {
        $factory = $this->getOptimusFactory();

        $return = $factory->make([
            'prime' => 'your-prime-integer',
            'inverse' => 'your-inverse-integer',
            'random' => 'your-random-integer',
        ]);

        $this->assertInstanceOf(Optimus::class, $return);
    }

    protected function getOptimusFactory()
    {
        return new OptimusFactory();
    }
}
