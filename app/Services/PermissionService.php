<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{
    /**
     * Check if the current user has a specific role.
     * 
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role) : bool
    {
        $user = Auth::user();
        return $user ? $user->hasRole($role) : false;
    }

    /**
     * Check if the current user has a specific permission.
     * 
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission) : bool
    {
        $user = Auth::user();
        return $user ? $user->can($permission) : false;
    }

    /**
     * Assign role to a user.
     * 
     *  @param \App\Models\User $user
     * @param string $roleName
     * @return void
     */
    public function assignRoleToUser(User $user, string $roleName) : void
    {
        if(Role::where('name', $roleName)->exists()){
            $user->assignRole($roleName);
        }

        if($roleName === 'admin'){
            $this->assignAdminPermissions($user);
        } else if($roleName === 'employee'){
            $this->assignEmployeePermissions($user);
        }
    }

    /**
     * Update the role of the user.
     * 
     *  @param User $user
     *  @param string $roleName
     * @return void
     */
    public function syncUserRole(User $user, string $roleName) : void
    {
        $user->syncRoles($roleName);
    }

    /**
     * Assign admin permissions to admin role.
     * 
     *  @param User $user
     * @return void
     */
    protected function assignAdminPermissions(User $user) : void
    {
        $permissions = [
            'manage users',
            'approve leaves',
            'reject leaves',
            'delete leaves',
            'view leaves'
        ];

        foreach ($permissions as $permission) {
            $user->givePermissionTo($permission);
        }
    }

    /**
     * Assign employee permission to employee role.
     * 
     *  @param User $user
     * @return void
     */
    protected function assignEmployeePermissions(User $user) : void
    {
        $permissions = [
            'apply for leave',
            'view leaves'
        ];
        
        foreach ($permissions as $permission) {
            $user->givePermissionTo($permission);
        }
        
    }

    /**
     * Assign permission to a role.
     * 
     *  @param string $roleName
     * @param string $permissionName
     * @return void
     */
    public function assignPermissionToRole(string $roleName, string $permissionName) : void
    {
        $role = Role::where('name', $roleName)->first();
        $permission = Permission::where('name', $permissionName)->first();

        if($role && $permission){
            $role->givePermissionTo($permission);
        }
    }

}
