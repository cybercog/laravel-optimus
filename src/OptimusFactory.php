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

namespace Cog\Laravel\Optimus;

use Jenssegers\Optimus\Optimus;

/**
 * Class OptimusFactory.
 *
 * @package Cog\Laravel\Optimus
 */
class OptimusFactory
{
    /**
     * Make a new Optimus client.
     *
     * @param array $config
     * @return \Jenssegers\Optimus\Optimus
     */
    public function make(array $config) : Optimus
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }

    /**
     * Get the configuration data.
     *
     * @param array $config
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    protected function getConfig(array $config) : array
    {
        return [
            'prime' => array_get($config, 'prime', 0),
            'inverse' => array_get($config, 'inverse', 0),
            'random' => array_get($config, 'random', 0),
        ];
    }

    /**
     * Get the optimus client.
     *
     * @param array $config
     * @return \Jenssegers\Optimus\Optimus
     */
    protected function getClient(array $config) : Optimus
    {
        return new Optimus($config['prime'], $config['inverse'], $config['random']);
    }
}
