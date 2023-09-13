<?php

namespace Cog\Tests\Laravel\Optimus\Stubs\Models;

use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class UserWithDefaultOptimusConnection extends Model
{
    use OptimusEncodedRouteKey;

    protected $table = 'users';

    protected $guarded = [];

    public function nestedUsers(): HasMany
    {
        return $this->hasMany(UserWithDefaultOptimusConnection::class, 'parent_id');
    }

    public function parentUser(): BelongsTo
    {
        return $this->belongsTo(UserWithDefaultOptimusConnection::class, 'parent_id');
    }
}
