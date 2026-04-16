<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Show user dashboard with their reports.
     */
    public function dashboard()
    {
        $reports = Auth::user()->reports()->latest()->paginate(10);
        return view('reports.dashboard', compact('reports'));
    }

    /**
     * Show the form to create a new report.
     */
    public function create()
    {
        return view('reports.create');
    }

    /**
     * Store a newly created report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'issue_type' => ['required', 'in:Leak,No water,Low pressure,Contaminated water'],
            'location' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'issue_type' => $request->issue_type,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image' => $imagePath,
            'status' => 'Pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Report submitted successfully!');
    }

    /**
     * Display the specified report.
     */
    public function show(Report $report)
    {
        if ($report->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $report->load('updates.admin');
        return view('reports.show', compact('report'));
    }
}
