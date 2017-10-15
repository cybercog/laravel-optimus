![cog-laravel-optimus](https://user-images.githubusercontent.com/1849174/28744713-5b28fffa-746f-11e7-8ca2-0e2a612bc19c.png)

<p align="center">
<a href="https://travis-ci.org/cybercog/laravel-optimus"><img src="https://img.shields.io/travis/cybercog/laravel-optimus/master.svg?style=flat-square" alt="Build Status"></a>
<a href="https://styleci.io/repos/77817858"><img src="https://styleci.io/repos/77817858/shield" alt="StyleCI"></a>
<a href="https://github.com/cybercog/laravel-optimus/releases"><img src="https://img.shields.io/github/release/cybercog/laravel-optimus.svg?style=flat-square" alt="Releases"></a>
<a href="https://github.com/cybercog/laravel-optimus/blob/master/LICENSE"><img src="https://img.shields.io/github/license/cybercog/laravel-optimus.svg?style=flat-square" alt="License"></a>
</p>

## Introduction

Laravel wrapper for the [Optimus Library](https://github.com/jenssegers/optimus) by [Jens Segers](https://github.com/jenssegers) with multiple connections support. Optimus is a small open-source library that generates short, unique, non-sequential ids from numbers. With this library, you can transform your internal id's to obfuscated integers based on Knuth's integer hash. It is similar to Hashids, but will generate integers instead of random strings. It is also super fast.

 ## Contents
 
 - [Features](#features)
 - [Installation](#installation)
 - [Configuration](#configuration)
 - [Usage](#usage)
 - [Change log](#change-log)
 - [Contributing](#contributing)
 - [Testing](#testing)
 - [Security](#security)
 - [Credits](#credits)
 - [Alternatives](#alternatives)
 - [License](#license)
 - [About CyberCog](#about-cybercog)

## Features

- Designed to work with Laravel Eloquent models.
- Configurable multiple connections support.
- Dependency Injection ready.
- Includes Facade.
- Following PHP Standard Recommendations:
  - [PSR-1 (Basic Coding Standard)](http://www.php-fig.org/psr/psr-1/).
  - [PSR-2 (Coding Style Guide)](http://www.php-fig.org/psr/psr-2/).
  - [PSR-4 (Autoloading Standard)](http://www.php-fig.org/psr/psr-4/).
- Covered with unit tests.

## Installation

First, pull in the package through Composer.

```sh
$ composer require cybercog/laravel-optimus
```

**If you are using Laravel 5.5 you can skip register package part.** 

#### Register package on Laravel 5.4 and lower

Include the service provider within `app/config/app.php`.

```php
'providers' => [
    Cog\Laravel\Optimus\Providers\OptimusServiceProvider::class,
],
```

If you want you can use the [facade](http://laravel.com/docs/facades). Add the reference in `config/app.php` to your aliases array.

```php
'aliases' => [
    'Optimus' => Cog\Laravel\Optimus\Facades\Optimus::class,
],
```

## Configuration

Laravel Optimus requires connection configuration. To get started, you'll need to publish config file:

```sh
$ php artisan vendor:publish --provider="Cog\Laravel\Optimus\Providers\OptimusServiceProvider" --tag="config"
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
$ php vendor/bin/optimus spark
```

Copy-paste generated integers to your connection config.

## Usage

#### OptimusManager

This is the class of most interest. It is bound to the ioc container as `optimus` and can be accessed using the `Facades\Optimus` facade. This class implements the ManagerInterface by extending AbstractManager. The interface and abstract class are both part of [Graham Campbell's](https://github.com/GrahamCampbell) [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package, so you may want to go and checkout the docs for how to use the manager class over at that repository. Note that the connection class returned will always be an instance of `Jenssegers\Optimus\Optimus`.

#### Facades\Optimus

This facade will dynamically pass static method calls to the `optimus` object in the ioc container which by default is the `OptimusManager` class.

#### OptimusServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.

#### Traits\OptimusEncodedRouteKey

This trait can be used in an Eloquent model to enable automatic route model binding. You can then type hint a model in a route closure or a controller and Laravel will try to find it based on the encoded ID. 

### Examples

Here you can see an example of just how simple this package is to use. Out of the box, the default adapter is `main`. After you enter your authentication details in the config file, it will just work:

#### Encode ID

```php 
Cog\Laravel\Optimus\Facades\Optimus::encode(20); // 1535832388
```

#### Decode ID

```php
Cog\Laravel\Optimus\Facades\Optimus::decode(1535832388); // 20
```

#### Alter Optimus connection

The Optimus manager will behave like it is a `Jenssegers\Optimus\Optimus`. If you want to call specific connections, you can do that with the connection method:

```php
use Cog\Laravel\Optimus\Facades\Optimus;

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
use Cog\Laravel\Optimus\OptimusManager;

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

#### Eloquent Model Trait

To enable implicit route model binding based on the encoded ID, all you need to do is [configure the prime numbers](#optimus-numbers-generation) and use the `OptimusEncodedRouteKey` trait in your model.

If you don't want to use the default Optimus connection, you can specify a custom connection by adding an `$optimusConnection` property to you model.

```php
use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;
use Illuminate\Database\Eloquent\Model;

class YourModel extends Model
{
    use OptimusEncodedRouteKey;
    
    protected $optimusConnection = 'custom'; // optional
}
```

Now you can type hint your model in a route closure or controller and Laravel will use the encoded ID to query the database.

Note that implicit route model binding requires Laravel's `SubstituteBindings` middleware, which is part of the `web` middleware group.

```php
Route::get('url/to/{model}', function (YourModel $model) {
    // ...
})->middleware('web');
```

To generate URL's to these routes you can either get the encoded route key:

```php
$encodedId = $model->getRouteKey();
$url = url("url/to/{$encodedId}");
```

Or you can use named routes and pass it the model. Laravel will do the rest.

```php
$url = route('my.named.route', [$model]);
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Testing

Run the tests with:

```sh
$ vendor/bin/phpunit
```

## Security

If you discover any security related issues, please email a.komarev@cybercog.su instead of using the issue tracker.

## Credits

|  | @mention |
|---|---|
| ![@a-komarev](https://avatars2.githubusercontent.com/u/1849174?s=64) | [@a-komarev](https://github.com/a-komarev) |

[Laravel Optimus contributors list](../../contributors)

Package was inspired by [Laravel Hashids](https://github.com/vinkla/laravel-hashids) package.

This package is a wrapper for [Optimus Library](https://github.com/jenssegers/optimus).

## Alternatives

- [vinkla/laravel-hashids](https://github.com/vinkla/laravel-hashids)
- [propaganistas/laravel-fakeid](https://github.com/Propaganistas/Laravel-FakeId)

*Feel free to add more alternatives as Pull Request.*

## License

- `Laravel Optimus` package is open-sourced software licensed under the [MIT license](LICENSE).

## About CyberCog

[CyberCog](http://www.cybercog.ru) is a Social Unity of enthusiasts. Research best solutions in product & software development is our passion.

- [Follow us on Twitter](https://twitter.com/cybercog)
- [Read our articles on Medium](https://medium.com/cybercog)

<a href="http://cybercog.ru"><img src="https://cloud.githubusercontent.com/assets/1849174/18418932/e9edb390-7860-11e6-8a43-aa3fad524664.png" alt="CyberCog"></a>
