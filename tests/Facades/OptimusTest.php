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

namespace Cog\Tests\Laravel\Optimus\Facades;

use Cog\Laravel\Optimus\Facades\Optimus;
use Cog\Laravel\Optimus\OptimusManager;
use Cog\Tests\Laravel\Optimus\AbstractTestCase;
use GrahamCampbell\TestBenchCore\FacadeTrait;

final class OptimusTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor(): string
    {
        return 'optimus';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass(): string
    {
        return Optimus::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected function getFacadeRoot(): string
    {
        return OptimusManager::class;
    }
}
