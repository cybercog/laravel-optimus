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

namespace Cog\Optimus\Providers;

use Cog\Optimus\OptimusFactory;
use Cog\Optimus\OptimusManager;
use Jenssegers\Optimus\Optimus;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;

/**
 * Class OptimusServiceProvider.
 *
 * @package Cog\Optimus
 */
class OptimusServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindFactory();
        $this->bindManager();
        $this->bindOptimus();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides() : array
    {
        return [
            'optimus',
            'optimus.factory',
            'optimus.connection',
        ];
    }

    /**
     * Setup the config.
     *
     * @return void
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__ . '/../../config/optimus.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('optimus.php')], 'config');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('optimus');
        }

        $this->mergeConfigFrom($source, 'optimus');
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    protected function bindFactory()
    {
        $this->app->singleton('optimus.factory', function () {
            return new OptimusFactory();
        });

        $this->app->alias('optimus.factory', OptimusFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    protected function bindManager()
    {
        $this->app->singleton('optimus', function (Container $app) {
            $config = $app['config'];
            $factory = $app['optimus.factory'];

            return new OptimusManager($config, $factory);
        });

        $this->app->alias('optimus', OptimusManager::class);
    }

    /**
     * Register the bindings.
     *
     * @return void
     */
    protected function bindOptimus()
    {
        $this->app->bind('optimus.connection', function (Container $app) {
            $manager = $app['optimus'];

            return $manager->connection();
        });

        $this->app->alias('optimus.connection', Optimus::class);
    }
}
