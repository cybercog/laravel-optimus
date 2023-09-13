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
use Jenssegers\Optimus\Optimus as JenssegersOptimus;

final class OptimusEncodedRouteKeyTest extends AbstractTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(config('database.default'));
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
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

    public function testResolveChildRouteWithEncodedKey(): void
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $nestedUser = $this->createUserWithDefaultOptimusConnection([
            'email' => 'test1@user.com',
        ]);
        $nestedUser->parentUser()->associate($user)->save();
        $resolvedNestedUser = $user->resolveChildRouteBinding('nested_user', $nestedUser->getRouteKey(), 'id');

        $this->assertEquals($nestedUser->id, $resolvedNestedUser->id);
    }

    public function testResolveModelWithEncodedKey(): void
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $encodedId = $user->getRouteKey();
        $resolvedUser = $user->resolveRouteBinding($encodedId);

        $this->assertEquals($user->id, $resolvedUser->id);
    }

    public function testResolveModelWithEncodedKeyWithCustomKey(): void
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $email = $user->email;
        $resolvedUser = $user->resolveRouteBinding($email, 'email');

        $this->assertEquals($user->id, $resolvedUser->id);
    }

    public function testResolveModelWithEncodedKeyWithCustomIdKey(): void
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $encodedId = $user->getRouteKey();
        $resolvedUser = $user->resolveRouteBinding($encodedId, 'id');

        $this->assertSame($user->id, $resolvedUser->id);
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

    public function testNonExistingIDsReturnNull()
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $resolvedUser = $user->resolveRouteBinding(999);

        $this->assertNull($resolvedUser);
    }

    public function testStringValuesReturnNull()
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $resolvedUser = $user->resolveRouteBinding('not-an-integer');

        $this->assertNull($resolvedUser);
    }

    public function testStringValuesContainingIntegersReturnNull()
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $resolvedUser = $user->resolveRouteBinding('1-not-just-an-integer');

        $this->assertNull($resolvedUser);
    }

    public function testStringValuesContainingEncodedRouteKeysReturnNull()
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $encodedRouteKey = $user->getRouteKey();
        $resolvedUser = $user->resolveRouteBinding("{$encodedRouteKey}-suffix-to-the-encoded-route-key");

        $this->assertNull($resolvedUser);
    }

    public function testArrayValuesReturnNull()
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $encodedRouteKey = $user->getRouteKey();
        $resolvedUser = $user->resolveRouteBinding([$encodedRouteKey]);

        $this->assertNull($resolvedUser);
    }

    public function testFloatValuesReturnNull()
    {
        $user = $this->createUserWithDefaultOptimusConnection();
        $resolvedUser = $user->resolveRouteBinding(12.3);

        $this->assertNull($resolvedUser);
    }

    public function testExistingIntegerValuesBelow256AreResolved()
    {
        $user = $this->createUserWithDefaultOptimusConnection();

        $optimus = $this->mock(JenssegersOptimus::class);
        $optimus->shouldReceive('decode')->with(123)->andReturn($user->id);
        Optimus::shouldReceive('connection')->andReturn($optimus);

        $resolvedUser = $user->resolveRouteBinding(123);

        $this->assertTrue($user->is($resolvedUser));
    }

    /**
     * Create a test user with default Optimus connection in the database.
     */
    protected function createUserWithDefaultOptimusConnection(array $attributes = []): UserWithDefaultOptimusConnection
    {
        return UserWithDefaultOptimusConnection::create(array_merge([
            'name' => 'Default Test User',
            'email' => 'test@user.com',
            'password' => 'p4ssw0rd',
        ], $attributes));
    }

    /**
     * Create a test user with custom Optimus connection in the database.
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
