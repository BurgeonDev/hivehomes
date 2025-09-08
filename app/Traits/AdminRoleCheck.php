<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait AdminRoleCheck
{
    /**
     * Allow only Super Admin and Society Admin.
     */
    protected function authorizeAdminRoles()
    {
        $user = Auth::user();

        if (! $user || (! $user->hasRole('super_admin') && ! $user->hasRole('society_admin'))) {
            throw new HttpException(403, 'You are not authorized to access this page.');
        }
    }

    /**
     * Allow only Super Admin.
     */
    protected function authorizeSuperAdmin()
    {
        $user = Auth::user();

        if (! $user || ! $user->hasRole('super_admin')) {
            throw new HttpException(403, 'Only Super Admin can access this page.');
        }
    }
}
