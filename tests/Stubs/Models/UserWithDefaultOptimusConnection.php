<?php

namespace Cog\Tests\Laravel\Optimus\Stubs\Models;

use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;
use Illuminate\Database\Eloquent\Model;

class UserWithDefaultOptimusConnection extends Model
{
    use OptimusEncodedRouteKey;

    protected $table = 'users';

    protected $guarded = [];
}
