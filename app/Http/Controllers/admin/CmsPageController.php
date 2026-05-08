<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CmsPage;

class CmsPageController extends Controller
{
    // LIST (Pagination)
    public function index()
    {
        $pages = CmsPage::latest()->get();
        return view('admin.cms_pages.index', compact('pages'));
    }

    // CREATE FORM
    public function create()
    {
        return view('admin.cms_pages.form');
    }

    // STORE DATA
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'slug'    => 'required|unique:cms_pages,slug',
            'content' => 'nullable',
            'status'  => 'required'
        ]);

        CmsPage::create([
            'title'   => $request->title,
            'slug'    => $request->slug,
            'content' => $request->content,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.cms-pages.index')
            ->with('success', 'CMS Page created successfully');
    }

    // EDIT FORM
    public function edit($id)
    {
        $page = CmsPage::findOrFail($id);
        return view('admin.cms_pages.form', compact('page'));
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $page = CmsPage::findOrFail($id);

        $request->validate([
            'title'   => 'required',
            'slug'    => 'required|unique:cms_pages,slug,' . $id,
            'content' => 'nullable',
            'status'  => 'required'
        ]);

        $page->update([
            'title'   => $request->title,
            'slug'    => $request->slug,
            'content' => $request->content,
            'status'  => $request->status,
        ]);

        return redirect()->route('admin.cms-pages.index')
            ->with('success', 'CMS Page updated successfully');
    }

    // DELETE
    public function destroy($id)
    {
        $page = CmsPage::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.cms-pages.index')
            ->with('success', 'CMS Page deleted successfully');
    }
}
