<?php

namespace App\Traits;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Adds role & permission awareness to a model (intended for the User model).
 *
 * All checks are eager-safe: once `roles` (and their `permissions`) are loaded
 * they are reused instead of hitting the database again.
 */
trait HasRoles
{
    /**
     * The roles assigned to the user.
     *
     * @return BelongsToMany<Role, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Determine if the user has ANY of the given role names.
     *
     * @param  string|array<int, string>  $role
     */
    public function hasRole(string|array $role): bool
    {
        $names = (array) $role;

        return $this->roles->whereIn('name', $names)->isNotEmpty();
    }

    /**
     * Determine if any of the user's roles grants the given permission.
     */
    public function hasPermission(string $name): bool
    {
        return $this->roles->contains(
            fn (Role $role): bool => $role->hasPermission($name)
        );
    }

    /**
     * Determine if the user can access something identified either by a role
     * name or by a permission name.
     */
    public function canAccess(string $roleOrPermission): bool
    {
        return $this->hasRole($roleOrPermission)
            || $this->hasPermission($roleOrPermission);
    }

    /**
     * Assign one or more roles to the user by name.
     *
     * Roles must already exist; missing names are ignored.
     */
    public function assignRole(string ...$names): void
    {
        $ids = Role::query()
            ->whereIn('name', $names)
            ->pluck('id');

        $this->roles()->syncWithoutDetaching($ids);
        $this->unsetRelation('roles');
    }

    /**
     * Remove one or more roles from the user by name.
     */
    public function removeRole(string ...$names): void
    {
        $ids = Role::query()
            ->whereIn('name', $names)
            ->pluck('id');

        $this->roles()->detach($ids);
        $this->unsetRelation('roles');
    }
}
