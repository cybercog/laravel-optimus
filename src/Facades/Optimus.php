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

namespace Cog\Optimus\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Optimus.
 *
 * @package Cog\Optimus\Facades
 */
class Optimus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() : string
    {
        return 'optimus';
    }
}
