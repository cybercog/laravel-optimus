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

namespace Cog\Laravel\Optimus;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use Jenssegers\Optimus\Optimus;

class OptimusFactory
{
    /**
     * Make a new Optimus client.
     *
     * @param array $config
     * @return \Jenssegers\Optimus\Optimus
     */
    public function make(array $config): Optimus
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }

    /**
     * Get the configuration data.
     *
     * @param array $config
     * @return array<string, int>
     *
     * @throws InvalidArgumentException
     */
    protected function getConfig(array $config): array
    {
        $prime = $config['prime'] ?? null;
        $inverse = $config['inverse'] ?? null;
        $random = $config['random'] ?? null;

        if (is_int($prime) === false) {
            throw new InvalidArgumentException(
                "Optimus `prime` value must be integer but `$prime` provided",
            );
        }
        if (is_int($prime) === false) {
            throw new InvalidArgumentException(
                "Optimus `inverse` value must be integer `$inverse` provided",
            );
        }
        if (is_int($random) === false) {
            throw new InvalidArgumentException(
                "Optimus `random` value must be integer `$random` provided",
            );
        }

        return [
            'prime' => $prime,
            'inverse' => $inverse,
            'random' => $random,
        ];
    }

    /**
     * Get the optimus client.
     *
     * @param array $config
     * @return \Jenssegers\Optimus\Optimus
     */
    protected function getClient(array $config): Optimus
    {
        return new Optimus($config['prime'], $config['inverse'], $config['random']);
    }
}
