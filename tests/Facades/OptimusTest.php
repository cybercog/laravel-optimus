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

namespace Cog\Optimus\Tests\Facades;

use Cog\Optimus\OptimusManager;
use Cog\Optimus\Facades\Optimus;
use Cog\Optimus\Tests\AbstractTestCase;
use GrahamCampbell\TestBenchCore\FacadeTrait;

/**
 * Class OptimusTest.
 *
 * @package Cog\Optimus\Tests\Facades
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
