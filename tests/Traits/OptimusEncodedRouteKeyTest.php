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

namespace Cog\Tests\Laravel\Optimus\Traits;

use Cog\Laravel\Optimus\Facades\Optimus;
use Cog\Tests\Laravel\Optimus\AbstractTestCase;
use Cog\Tests\Laravel\Optimus\Stubs\Models\UserWithCustomOptimusConnection;
use Cog\Tests\Laravel\Optimus\Stubs\Models\UserWithDefaultOptimusConnection;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\Facades\Route;

class OptimusEncodedRouteKeyTest extends AbstractTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(config('database.default'));
        $this->configurePrimeNumbers();
    }

    public function testRouteKeyIsEncoded(): void
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $encodedId = Optimus::encode($user->id);

        $this->assertEquals($encodedId, $user->getRouteKey());
    }

    public function testOptimusConnectionCanBeConfigured(): void
    {
        $user = $this->createUserWithCustomOptimusConnection();
        $routeKey = $user->getRouteKey();

        $correctEncodedId = Optimus::connection('custom')->encode($user->id);
        $incorrectEncodedId = Optimus::connection('main')->encode($user->id);

        $this->assertEquals($correctEncodedId, $routeKey);
        $this->assertNotEquals($incorrectEncodedId, $routeKey);
    }

    public function testResolveModelWithEncodedKey(): void
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $encodedId = $user->getRouteKey();
        $resolvedUser = $user->resolveRouteBinding($encodedId);

        $this->assertEquals($user->id, $resolvedUser->id);
    }

    public function testEncodedKeyIsUsedForRouteModelBinding(): void
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $encodedId = $user->getRouteKey();

        Route::get('users/{user}', function (UserWithDefaultOptimusConnection $user) {
            return $user;
        })->middleware(SubstituteBindings::class);

        $this->get("users/{$encodedId}")->assertJsonFragment(['id' => $user->id]);
    }

    public function testEncodedRouteKeyIsUsedWhenGeneratingNamedRouteUrls(): void
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $encodedId = Optimus::encode($user->id);

        Route::get('users/{user}', function () {
        })->name('test.route');

        $expectedUrl = "{$this->baseUrl}/users/{$encodedId}";
        $generatedUrl = route('test.route', $user);

        $this->assertEquals($expectedUrl, $generatedUrl);
    }

    /**
     * Create a test user with default Optimus connection in the database.
     *
     * @return \Cog\Tests\Laravel\Optimus\Stubs\Models\UserWithDefaultOptimusConnection
     */
    protected function createUserWithDefaultOptimusConnection(): UserWithDefaultOptimusConnection
    {
        return UserWithDefaultOptimusConnection::create([
            'name' => 'Default Test User',
            'email' => 'test@user.com',
            'password' => 'p4ssw0rd',
        ]);
    }

    /**
     * Create a test user with custom Optimus connection in the database.
     *
     * @return \Cog\Tests\Laravel\Optimus\Stubs\Models\UserWithCustomOptimusConnection
     */
    protected function createUserWithCustomOptimusConnection(): UserWithCustomOptimusConnection
    {
        return UserWithCustomOptimusConnection::create([
            'name' => 'Custom Test User',
            'email' => 'test@user.com',
            'password' => 'p4ssw0rd',
        ]);
    }

    /**
     * Configure some random prime numbers.
     *
     * @return void
     */
    protected function configurePrimeNumbers(): void
    {
        config()->set('optimus.connections', [
            'main' => [
                'prime' => 1490261603,
                'inverse' => 1573362507,
                'random' => 1369544188,
            ],
            'custom' => [
                'prime' => 1770719809,
                'inverse' => 1417283009,
                'random' => 508877541,
            ],
        ]);
    }
}
