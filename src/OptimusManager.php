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
use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

/**
 * Class OptimusManager.
 *
 * @package Cog\Laravel\Optimus
 */
class OptimusManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \Cog\Laravel\Optimus\OptimusFactory
     */
    private $factory;

    /**
     * Create a new Optimus manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Cog\Laravel\Optimus\OptimusFactory $factory
     * @return void
     */
    public function __construct(Repository $config, OptimusFactory $factory)
    {
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
     *
     * @return string
     */
    protected function getConfigName(): string
    {
        return 'optimus';
    }

    /**
     * Get the factory instance.
     *
     * @return \Cog\Laravel\Optimus\OptimusFactory
     */
    public function getFactory(): OptimusFactory
    {
        return $this->factory;
    }
}
