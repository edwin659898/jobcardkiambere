<?php

namespace App\Http\Controllers;

use App\Imports\ImportChildActivities;
use App\Models\ChildActivity;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->with('roles')
            ->when(request()->input('search'), function ($query, $search) {
                $query->Where('name', 'like', "%{$search}%");
                $query->orWhere('site', 'like', "%{$search}%");
                $query->orWhere('department', 'like', "%{$search}%");
                $query->orWhereHas('roles', function ($query) use ($search) {
                    $query->where('role', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'department' => $user->department,
                'site' => $user->site,
                'roles' => $user->roles,
            ]);

        $AllRoles = Role::select('id', 'role')->take(5)->latest()->get();

        return Inertia::render('Roles/UserTable', [
            'Users' => $users,
            'CreatedRoles' => $AllRoles,
            'filters' => request()->all('search'),
        ]);
    }

    public function editUserRoles($id)
    {
        $user = User::findOrFail($id);
        $currentRoles = DB::table('role_user')
            ->where(['user_id' => $id])
            ->pluck('role_id')
            ->toArray();
        $roles = Role::all();

        return Inertia::render('Roles/UserEdit', [
            'User' => $user,
            'CurrentRoles' => $currentRoles,
            'Roles' => $roles
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->roles()->attach($request->checkedRoles);
        return redirect()->route('user.roles')->with('success', 'Roles Updated Successfully');
    }

    public function createRole(Request $request)
    {
        $request->validate([
            'role' => 'required|unique:roles',
        ]);

        Role::create(['role' => strtoupper($request->role)]);
        return redirect()->route('user.roles')->with('success', 'Role created Successfully');
    }

    public function destroyRole($id)
    {
        Role::findOrFail($id)->delete();
        return redirect()->route('user.roles')->with('success', 'Role destroyed Successfully');
    }

    public function ActivityIndex()
    {
        $activities = ChildActivity::query()
            ->with('roles')
            ->when(request()->input('search'), function ($query, $search) {
                $query->Where('child_title', 'like', "%{$search}%");
                $query->orWhereHas('roles', function ($query) use ($search) {
                    $query->where('role', 'like', "%{$search}%");
                });
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($activity) => [
                'id' => $activity->id,
                'name' => $activity->child_title,
                'roles' => $activity->roles,
            ]);

        $AllRoles = Role::select('id', 'role')->get();

        return Inertia::render('Roles/ActivityTable', [
            'Activities' => $activities,
            'CreatedRoles' => $AllRoles,
            'filters' => request()->all('search'),
        ]);
    }

    public function editActivityRoles($id)
    {
        $activity = ChildActivity::findOrFail($id);
        $currentRoles = DB::table('child_activity_role')
            ->where(['child_activity_id' => $id])
            ->pluck('role_id')
            ->toArray();
        $roles = Role::all();

        return Inertia::render('Roles/ActivityEdit', [
            'Activity' => $activity,
            'CurrentRoles' => $currentRoles,
            'Roles' => $roles
        ]);
    }

    public function updateActivity(Request $request, $id)
    {
        $user = ChildActivity::findOrFail($id);
        $user->roles()->detach();
        $user->roles()->attach($request->checkedRoles);
        return redirect()->route('activity.roles')->with('success', 'Roles Updated Successfully');
    }

    public function uploadActivities(Request $request){
        Excel::import(new ImportChildActivities, request()->file('file'));
        return redirect()->route('Dashboard');
    }
}
