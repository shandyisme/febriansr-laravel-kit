<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Read-only pages that surface the RBAC and activity data:
 * roles with their permissions, and the paginated activity log.
 */
class AccessController extends Controller
{
    /**
     * List roles together with their assigned permissions.
     */
    public function roles(): View
    {
        $roles = Role::with('permissions')->get();

        return view('access.roles', compact('roles'));
    }

    /**
     * Show the most recent activity log entries, paginated.
     */
    public function activity(Request $request): View
    {
        $logs = ActivityLog::with('user')->latest()->paginate(15);

        return view('access.activity', compact('logs'));
    }
}
