<?php

namespace Cog\Tests\Laravel\Optimus\Stubs\Models;

use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;
use Illuminate\Database\Eloquent\Model;

final class UserWithDefaultOptimusConnection extends Model
{
    use OptimusEncodedRouteKey;

    protected $table = 'users';

    protected $guarded = [];
}
