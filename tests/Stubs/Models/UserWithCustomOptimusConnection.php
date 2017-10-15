<?php

namespace Cog\Tests\Laravel\Optimus\Stubs\Models;

use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;
use Illuminate\Database\Eloquent\Model;

class UserWithCustomOptimusConnection extends Model
{
    use OptimusEncodedRouteKey;

    protected $optimusConnection = 'custom';

    protected $table = 'users';
    protected $guarded = [];
}
