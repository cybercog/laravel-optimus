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

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;
use Jenssegers\Optimus\Optimus;

class OptimusManager extends AbstractManager
{
    /**
     * The factory instance.
     */
    private OptimusFactory $factory;

    public function __construct(
        Repository $config,
        OptimusFactory $factory
    ) {
        parent::__construct($config);

        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     * @return \Jenssegers\Optimus\Optimus
     */
    protected function createConnection(array $config): Optimus
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     */
    protected function getConfigName(): string
    {
        return 'optimus';
    }

    /**
     * Get the factory instance.
     */
    public function getFactory(): OptimusFactory
    {
        return $this->factory;
    }
}
