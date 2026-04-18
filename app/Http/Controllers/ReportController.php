<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function dashboard(Request $request)
    {
        $perPage = $request->input('per_page', 5);
        $perPage = in_array($perPage, [2, 3, 4, 5, 10, 15, 20, 50]) ? $perPage : 5;
        
        $reports = Auth::user()->reports()->latest()->paginate($perPage);
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('reports.partials.reports-list', compact('reports'))->render(),
                'pagination' => $reports->appends(['per_page' => $perPage])->links('pagination::bootstrap-5')->render(),
            ]);
        }
        
        return view('reports.dashboard', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'issue_type' => ['required', 'in:Leak,No water,Low pressure,Contaminated water'],
            'location' => ['required', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'images' => ['nullable'],
            'images.*' => ['image', 'max:5120'],
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('reports', 'public');
                    $imagePaths[] = $path;
                }
            }
        }

        Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'issue_type' => $request->issue_type,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'images' => $imagePaths,
            'status' => 'Pending',
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Report submitted successfully!',
                'redirect' => route('dashboard')
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Report submitted successfully!');
    }

    public function show(Report $report)
    {
        if ($report->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $report->load('updates.admin');
        return view('reports.show', compact('report'));
    }
}
