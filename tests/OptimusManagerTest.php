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

use Mockery;
use Cog\Optimus\OptimusFactory;
use Cog\Optimus\OptimusManager;
use Jenssegers\Optimus\Optimus;
use Illuminate\Contracts\Config\Repository;
use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;

/**
 * Class OptimusManagerTest.
 *
 * @package Cog\Optimus\Tests
 */
class OptimusManagerTest extends AbstractTestBenchTestCase
{
    public function testCreateConnection()
    {
        $config = ['path' => __DIR__];

        $manager = $this->getManager($config);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('optimus.default')->andReturn('optimus');

        $this->assertSame([], $manager->getConnections());

        $return = $manager->connection();

        $this->assertInstanceOf(Optimus::class, $return);

        $this->assertArrayHasKey('optimus', $manager->getConnections());
    }

    protected function getManager(array $config)
    {
        $repository = Mockery::mock(Repository::class);
        $factory = Mockery::mock(OptimusFactory::class);

        $manager = new OptimusManager($repository, $factory);

        $manager->getConfig()->shouldReceive('get')->once()
            ->with('optimus.connections')->andReturn(['optimus' => $config]);

        $config['name'] = 'optimus';

        $manager->getFactory()->shouldReceive('make')->once()
            ->with($config)->andReturn(Mockery::mock(Optimus::class));

        return $manager;
    }
}
