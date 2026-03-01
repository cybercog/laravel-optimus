# AGENTS.md

This file provides guidance to LLM Agents when working with code in this repository.

## Project Overview

Laravel Optimus is a PHP package (`cybercog/laravel-optimus`) — a Laravel bridge for [jenssegers/optimus](https://github.com/jenssegers/optimus). Provides ID obfuscation based on Knuth's multiplicative hashing method, transforming integer IDs into obfuscated integers. Supports multiple named connections. Compatible with Laravel 8-13 and PHP 7.4-8.5.

## Commands

All commands run through Docker. Services: `php81`, `php82`, `php83`, `php84`, `php85`.

```bash
# Build and start containers
docker compose up -d --build

# Install dependencies
docker compose exec php85 composer install

# Run all tests (uses in-memory SQLite)
docker compose exec php85 composer test

# Run a single test file
docker compose exec php85 vendor/bin/phpunit tests/Unit/OptimusFactoryTest.php

# Run a single test method
docker compose exec php85 vendor/bin/phpunit --filter test_method_name
```

No standalone lint/static analysis command — style is enforced externally by StyleCI (Laravel preset, PSR-12).

## Namespaces & Autoloading

- `Cog\Laravel\Optimus\` → `src/` (implementations)
- `Cog\Tests\Laravel\Optimus\` → `tests/` (tests)

## Architecture

### Core Design

The package uses `graham-campbell/manager` for multi-connection management — the same pattern as `laravel-github`, `laravel-gitlab`, etc.

- **OptimusFactory** — Creates `Jenssegers\Optimus\Optimus` instances from `[prime, inverse, random]` config arrays.
- **OptimusManager** — Extends `GrahamCampbell\Manager\AbstractManager`. Manages named connections (e.g., `main`, `alternative`). Each connection is an `Optimus` instance. Config key: `optimus`.
- **Facade** (`Facades\Optimus`) — Accessor `'optimus'` resolves to `OptimusManager`. Supports `Optimus::encode()`, `Optimus::decode()`, `Optimus::connection('name')`.
- **ServiceProvider** — Registers three container bindings: `optimus.factory` (singleton), `optimus` (singleton manager), `optimus.connection` (default connection). Handles both Laravel and Lumen.
- **OptimusEncodedRouteKey trait** — For Eloquent models. Overrides `getRouteKey()` to encode and `resolveRouteBinding()`/`resolveRouteBindingQuery()` to decode. Supports per-model connection via `$optimusConnection` property.

## Testing

Tests extend `GrahamCampbell\TestBench\AbstractPackageTestCase` via `AbstractTestCase`. This base class boots a Laravel app with the package's service provider registered. Test traits `FacadeTrait` and `ServiceProviderTrait` from testbench handle boilerplate facade/provider assertions.

PHPUnit uses in-memory SQLite (configured in `phpunit.xml.dist`).

## Code Conventions

- All PHP files use `declare(strict_types=1)`.
- All files include the copyright header block.
- PSR-12 coding style.
