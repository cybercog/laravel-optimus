<?php

/*
 * This file is part of Laravel Optimus.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cog\Tests\Laravel\Optimus\Stubs\Models;

use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class UserWithCustomOptimusConnection extends Model
{
    use OptimusEncodedRouteKey;

    protected string $optimusConnection = 'custom';

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
