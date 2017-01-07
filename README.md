![cog-laravel-optimus-3](https://cloud.githubusercontent.com/assets/1849174/21738350/6c08b624-d494-11e6-9895-94e7d5f39010.png)

<p align="center">
<a href="https://travis-ci.org/cybercog/laravel-optimus"><img src="https://img.shields.io/travis/cybercog/laravel-optimus/master.svg?style=flat-square" alt="Build Status"></a>
<a href="https://styleci.io/repos/77817858"><img src="https://styleci.io/repos/77817858/shield" alt="StyleCI"></a>
<a href="https://github.com/cybercog/laravel-optimus/releases"><img src="https://img.shields.io/github/release/cybercog/laravel-optimus.svg?style=flat-square" alt="Releases"></a>
<a href="https://github.com/cybercog/laravel-optimus/blob/master/LICENSE"><img src="https://img.shields.io/github/license/cybercog/laravel-optimus.svg?style=flat-square" alt="License"></a>
</p>

## Introduction

Laravel wrapper for the [Optimus Library](https://github.com/jenssegers/optimus) by Jens Segers with multiple connections. Optimus is a small open-source library that generates short, unique, non-sequential ids from numbers. With this library, you can transform your internal id's to obfuscated integers based on Knuth's integer hash. It is similar to Hashids, but will generate integers instead of random strings. It is also super fast.

## Installation

First, pull in the package through Composer.

```sh
composer require cybercog/optimus
```

And then include the service provider within `app/config/app.php`.

```php
'providers' => [
    Cog\Optimus\OptimusServiceProvider::class,
],
```

If you want you can use the [facade](http://laravel.com/docs/facades). Add the reference in `config/app.php` to your aliases array.

```php
'aliases' => [
    'Optimus' => Cog\Optimus\Facades\Optimus::class,
],
```

## Configuration

Laravel Optimus requires connection configuration. To get started, you'll need to publish config file:

```bash
php artisan vendor:publish --provider="Cog\Optimus\Providers\OptimusServiceProvider" --tag="config"
```

This will create a `config/optimus.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

#### Default Connection Name

This option `default` is where you may specify which of the connections below you wish to use as your default connection for all work. Of course, you may use many connections at once using the manager class. The default value for this setting is `main`.

#### Optimus Connections

This option `connections` is where each of the connections are setup for your application. Example configuration has been included, but you may add as many connections as you would like.

#### Optimus numbers generation

To get started you will need 3 keys in main connection;

- `prime`: Large prime number lower than `2147483647`
- `inverse`: The inverse prime so that `(PRIME * INVERSE) & MAXID == 1`
- `random`: A large random integer lower than `2147483647`

Luckily for you, there is console command that can do all of this for you, just run the following command:

```sh
php vendor/bin/optimus spark
```

Copy-paste generated integers to your connection config.

## Usage

#### OptimusManager

This is the class of most interest. It is bound to the ioc container as `optimus` and can be accessed using the `Facades\Optimus` facade. This class implements the ManagerInterface by extending AbstractManager. The interface and abstract class are both part of [Graham Campbell's](https://github.com/GrahamCampbell) [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package, so you may want to go and checkout the docs for how to use the manager class over at that repository. Note that the connection class returned will always be an instance of `Jenssegers\Optimus\Optimus`.

#### Facades\Optimus

This facade will dynamically pass static method calls to the `optimus` object in the ioc container which by default is the `OptimusManager` class.

#### OptimusServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.

### Examples

Here you can see an example of just how simple this package is to use. Out of the box, the default adapter is `main`. After you enter your authentication details in the config file, it will just work:

#### Encode ID

```php 
Cog\Optimus\Facades\Optimus::encode(20); // 1535832388
```

#### Decode ID

```php
Cog\Optimus\Facades\Optimus::decode(1535832388); // 20
```

#### Alter Optimus connection

The Optimus manager will behave like it is a `Jenssegers\Optimus\Optimus`. If you want to call specific connections, you can do that with the connection method:

```php
use Cog\Optimus\Facades\Optimus;

// Writing this…
Optimus::connection('main')->encode($id);

// …is identical to writing this
Optimus::encode($id);

// and is also identical to writing this.
Optimus::connection()->encode($id);

// This is because the main connection is configured to be the default.
Optimus::getDefaultConnection(); // This will return main.

// We can change the default connection.
Optimus::setDefaultConnection('alternative'); // The default is now alternative.
```

#### Dependency Injection

If you prefer to use dependency injection over facades like me, then you can inject the manager:

```php
use Cog\Optimus\OptimusManager;

class Foo
{
	protected $optimus;

	public function __construct(OptimusManager $optimus)
	{
		$this->optimus = $optimus;
	}

	public function bar($id)
	{
		return $this->optimus->encode($id)
	}
}

app()->make('Foo')->bar(20);
```

## Testing

Run the tests with:

```sh
vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email a.komarev@cybercog.su instead of using the issue tracker.

## Credits

- [Anton Komarev](https://github.com/a-komarev)
- [All Contributors](../../contributors)

Package was inspired by [Laravel Hashids](https://github.com/vinkla/laravel-hashids) package.

This package is a wrapper for [Optimus Library](https://github.com/jenssegers/optimus).

## Alternatives

*Not found.*

*Feel free to add more alternatives as Pull Request.*

## License

- `Laravel Optimus` package is open-sourced software licensed under the [MIT license](LICENSE).

## About CyberCog

[CyberCog](http://www.cybercog.ru) is a Social Unity of enthusiasts. Research best solutions in product & software development is our passion.

![cybercog-logo](https://cloud.githubusercontent.com/assets/1849174/18418932/e9edb390-7860-11e6-8a43-aa3fad524664.png)
