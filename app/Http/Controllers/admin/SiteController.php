<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sites = Site::latest()->paginate(10);
        return view('admin.sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.sites.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'status' => 'required|in:0,1',
        ]);

        // Create
        Site::create([
            'site_name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.sites.index')
                         ->with('success', 'Site created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $site = Site::findOrFail($id);
        return view('admin.sites.show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $site = Site::findOrFail($id);
        return view('admin.sites.form', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $site = Site::findOrFail($id);

        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'status' => 'required|in:0,1',
        ]);

        // Update
        $site->update([
            'site_name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.sites.index')
                         ->with('success', 'Site updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $site = Site::findOrFail($id);
        $site->delete();

        return redirect()->route('admin.sites.index')
                         ->with('success', 'Site deleted successfully');
    }
}