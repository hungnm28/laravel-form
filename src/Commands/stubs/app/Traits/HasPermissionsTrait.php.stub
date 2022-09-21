<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait
{

    public function givePermissionsTo(...$permissions)
    {

        $permissions = $this->getAllPermissions($permissions);
        if ($permissions === null) {
            return $this;
        }
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                $this->permissions()->save($permission);
            }
        }

        return $this;
    }

    public function withdrawPermissionsTo(...$permissions)
    {

        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;

    }

    public function refreshPermissions(...$permissions)
    {

        $this->permissions()->detach();
        return $this->givePermissionsTo(...$permissions);
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission)
    {

        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasAllPermission()
    {
        $sup = $this->givePermissionsTo("*");
        if ($sup) {
            return $this->hasPermission($sup);
        }
        return false;
    }

    public function hasAllPermissionThroughRole()
    {
        $sup = $this->givePermissionsTo('*');
        foreach ($this->roles as $role) {
            if ($role->permissions->contains($sup)) {
                return true;
            }
        }
        return false;
    }

    public function refreshRoleIds($ids)
    {
        $this->roles()->detach();
        Role::find($ids)->map(function ($role) {
            $this->roles()->save($role);
        });
    }

    public function hasRoleIds(...$ids){
        // check super admins
        if($this->isSuperAdmin()){
            return true;
        }
        foreach ($ids as $role) {
            if ($this->roles->contains('id', $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole(...$roles)
    {
        // check super admins
        if($this->isSuperAdmin()){
            return true;
        }

        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }

    public function roles()
    {

        return $this->belongsToMany(Role::class, 'users_roles');

    }

    public function permissions()
    {

        return $this->belongsToMany(Permission::class, 'users_permissions');

    }

    protected function hasPermission($permission)
    {

        return (bool)$this->permissions->where('name', $permission->name)->count();
    }

    protected function getAllPermissions(array $permissions)
    {

        return Permission::whereIn('name', $permissions)->get();

    }

}
