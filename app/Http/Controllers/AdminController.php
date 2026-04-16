<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Update;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $stats = [
            'total' => Report::count(),
            'pending' => Report::pending()->count(),
            'in_progress' => Report::inProgress()->count(),
            'resolved' => Report::resolved()->count(),
        ];

        $reportsPerPage = $request->input('per_page_reports', 15);
        $reportsPerPage = in_array($reportsPerPage, [5, 10, 20, 50, 100, 1000]) ? $reportsPerPage : 15;
        
        $usersPerPage = $request->input('per_page_users', 15);
        $usersPerPage = in_array($usersPerPage, [5, 10, 20, 50, 100, 1000]) ? $usersPerPage : 15;

        $reports = Report::with('user')->latest()->paginate($reportsPerPage);
        $users = User::withCount('reports')->latest()->paginate($usersPerPage);
        
        return view('admin.dashboard', compact('reports', 'stats', 'users', 'reportsPerPage', 'usersPerPage'));
    }

    public function showReport(Report $report)
    {
        $report->load(['user', 'updates.admin']);
        return view('admin.show-report', compact('report'));
    }

    public function updateReport(Request $request, Report $report)
    {
        $request->validate([
            'status' => ['required', 'in:Pending,In Progress,Resolved'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $report->update([
            'status' => $request->status,
        ]);

        Update::create([
            'report_id' => $report->id,
            'admin_id' => Auth::id(),
            'status' => $request->status,
            'comment' => $request->comment ?: 'Status changed to ' . $request->status,
        ]);

        return redirect()->route('admin.reports.show', $report)->with('success', 'Report updated successfully!');
    }

    public function reportsByStatus($status)
    {
        $validStatuses = ['Pending', 'In Progress', 'Resolved'];
        if (!in_array($status, $validStatuses)) {
            abort(404);
        }

        $stats = [
            'total' => Report::count(),
            'pending' => Report::pending()->count(),
            'in_progress' => Report::inProgress()->count(),
            'resolved' => Report::resolved()->count(),
        ];

        $reports = Report::where('status', $status)->with('user')->latest()->paginate(15);
        return view('admin.dashboard', compact('reports', 'stats'));
    }

    public function users()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,user'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->role === 'admin',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully!');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_admin' => ['sometimes', 'boolean'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->boolean('is_admin'),
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.dashboard')->with('error', 'You cannot delete yourself!');
        }

        foreach ($user->reports as $report) {
            if ($report->images) {
                foreach ($report->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully!');
    }
}
