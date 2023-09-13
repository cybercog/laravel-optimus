<?php

namespace Cog\Tests\Laravel\Optimus\Stubs\Models;

use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class UserWithCustomOptimusConnection extends Model
{
    use OptimusEncodedRouteKey;

    protected $optimusConnection = 'custom';

    protected $table = 'users';

    protected $guarded = [];

    public function nestedUsers(): HasMany
    {
        return $this->hasMany(UserWithCustomOptimusConnection::class, 'parent_id');
    }

    public function parentUser(): BelongsTo
    {
        return $this->belongsTo(UserWithCustomOptimusConnection::class, 'parent_id');
    }
}
