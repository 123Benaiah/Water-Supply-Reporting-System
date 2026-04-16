<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Update;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total' => Report::count(),
            'pending' => Report::pending()->count(),
            'in_progress' => Report::inProgress()->count(),
            'resolved' => Report::resolved()->count(),
        ];

        $reports = Report::with('user')->latest()->paginate(15);
        return view('admin.dashboard', compact('reports', 'stats'));
    }

    /**
     * Show the specified report for editing.
     */
    public function showReport(Report $report)
    {
        $report->load(['user', 'updates.admin']);
        return view('admin.show-report', compact('report'));
    }

    /**
     * Update report status.
     */
    public function updateReport(Request $request, Report $report)
    {
        $request->validate([
            'status' => ['required', 'in:Pending,In Progress,Resolved'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $report->update([
            'status' => $request->status,
        ]);

        if ($request->comment) {
            Update::create([
                'report_id' => $report->id,
                'admin_id' => Auth::id(),
                'status' => $request->status,
                'comment' => $request->comment,
            ]);
        } else {
            Update::create([
                'report_id' => $report->id,
                'admin_id' => Auth::id(),
                'status' => $request->status,
                'comment' => 'Status changed to ' . $request->status,
            ]);
        }

        return redirect()->route('admin.reports.show', $report)->with('success', 'Report updated successfully!');
    }

    /**
     * Show all users.
     */
    public function users()
    {
        $users = User::where('is_admin', false)->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * Show reports filtered by status.
     */
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
}
