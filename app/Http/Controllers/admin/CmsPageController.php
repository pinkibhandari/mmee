<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    // LIST
    public function index(Request $request)
    {
        $pages = CmsPage::query()

            // Search
            ->when($request->filled('search'), function ($q) use ($request) {

                $q->where(function ($query) use ($request) {

                    $query->where('title', 'like', '%' . $request->search . '%')
                          ->orWhere('slug', 'like', '%' . $request->search . '%');

                });

            })

            // Status Filter
            ->when($request->filled('status'), function ($q) use ($request) {

                $q->where('status', $request->status);

            })
            ->latest()
            ->paginate(2)
            ->withQueryString();

        return view('admin.cms_pages.index', compact('pages'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.cms_pages.form', [
            'page' => new CmsPage()
        ]);
    }

    // STORE
    public function store(Request $request)
    {
        
        $data = $this->validateData($request);
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        CmsPage::create($data);

        return redirect()
            ->route('admin.cms-pages.index')
            ->with('success', 'CMS Page created successfully');
    }

    // EDIT
    public function edit(CmsPage $cms_page)
    {
        return view('admin.cms_pages.form', [
            'page' => $cms_page
        ]);
    }

    // UPDATE
    public function update(Request $request, CmsPage $cms_page)
    {
        // AJAX Status Update
        if ($request->has('status') && !$request->has('title')) {

            $cms_page->update([
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Status updated successfully'
            ]);
        }

        $data = $this->validateData($request);

        // Update Slug if Title Changed
        if ($cms_page->title !== $data['title']) {

            $data['slug'] = $this->generateUniqueSlug(
                $data['title'],
                $cms_page->id
            );

        }

        $cms_page->update($data);

        return redirect()
            ->route('admin.cms-pages.index')
            ->with('success', 'CMS Page updated successfully');
    }

    // DELETE
    public function destroy(CmsPage $cms_page)
    {
        $cms_page->delete();

        return redirect()
            ->route('admin.cms-pages.index')
            ->with('success', 'CMS Page deleted successfully');
    }

    // VALIDATION
    private function validateData(Request $request)
    {
        return $request->validate([

            'title'   => 'required|string|max:255',

            // 'slug'    => 'nullable|string|max:255',


            'content' => 'required|string',

            'status'  => 'required|in:0,1',

        ]);
    }

    // UNIQUE SLUG
    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);

        $originalSlug = $slug;

        $count = 1;

        while (

            CmsPage::when($ignoreId, fn($q) =>
                $q->where('id', '!=', $ignoreId)
            )

            ->where('slug', $slug)
            ->exists()

        ) {

            $slug = $originalSlug . '-' . $count++;

        }

        return $slug;
    }
}