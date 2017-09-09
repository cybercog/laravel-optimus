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

namespace Cog\Tests\Laravel\Optimus\Facades;

use Cog\Laravel\Optimus\OptimusManager;
use Cog\Laravel\Optimus\Facades\Optimus;
use Cog\Tests\Laravel\Optimus\AbstractTestCase;
use GrahamCampbell\TestBenchCore\FacadeTrait;

/**
 * Class OptimusTest.
 *
 * @package Cog\Tests\Laravel\Optimus\Facades
 */
class OptimusTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor()
    {
        return 'optimus';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return Optimus::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        return OptimusManager::class;
    }
}
