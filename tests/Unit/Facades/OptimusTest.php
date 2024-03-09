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
use GrahamCampbell\TestBenchCore\FacadeTrait;

final class OptimusTest extends AbstractTestCase
{
    use FacadeTrait;

    protected static function getFacadeAccessor(): string
    {
        return 'optimus';
    }

    protected static function getFacadeClass(): string
    {
        return Optimus::class;
    }

    protected static function getFacadeRoot(): string
    {
        return OptimusManager::class;
    }
}
