<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'label'])]
class Role extends Model
{
    /**
     * The users that belong to the role.
     *
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The permissions that belong to the role.
     *
     * @return BelongsToMany<Permission, $this>
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Determine if the role has the given permission (eager-safe).
     */
    public function hasPermission(string $name): bool
    {
        return $this->permissions->contains('name', $name);
    }

    /**
     * Grant the given permission(s) to the role by name.
     *
     * Permissions must already exist; missing names are ignored.
     */
    public function givePermissionTo(string ...$names): void
    {
        $ids = Permission::query()
            ->whereIn('name', $names)
            ->pluck('id');

        $this->permissions()->syncWithoutDetaching($ids);
    }
}
