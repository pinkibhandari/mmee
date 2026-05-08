@extends('admin.layouts.app')

@section('content')

<div class="card shadow mb-4">

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">
            <strong>
                {{ isset($page) ? 'Edit CMS Page' : 'Create CMS Page' }}
            </strong>
        </h6>

        <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-sm btn-secondary">
            Back
        </a>
    </div>

    <div class="card-body">

        <form action="{{ isset($page) 
                ? route('admin.cms-pages.update', $page->id) 
                : route('admin.cms-pages.store') }}"
              method="POST">

            @csrf
            @if(isset($page))
                @method('PUT')
            @endif

            <!-- Title -->
            <div class="mb-3">
                <label>Title</label>
                <input type="text"
                       name="title"
                       id="title"
                       class="form-control"
                       value="{{ $page->title ?? old('title') }}"
                       required>
            </div>

            <!-- Slug -->
            <div class="mb-3">
                <label>Slug</label>
                <input type="text"
                       name="slug"
                       id="slug"
                       class="form-control"
                       value="{{ $page->slug ?? old('slug') }}"
                       required>
            </div>

            <!-- Content (CKEditor) -->
            <div class="mb-3">
                <label>Content</label>
                <textarea name="content"
                          id="content"
                          class="form-control"
                          rows="6">{{ $page->content ?? old('content') }}</textarea>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ isset($page) && $page->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ isset($page) && $page->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button class="btn btn-primary">
                {{ isset($page) ? 'Update' : 'Save' }}
            </button>

        </form>

    </div>
</div>

@endsection

@section('scripts')

<!-- Slug Auto Generate -->
<script>
document.getElementById('title').addEventListener('keyup', function () {
    let slug = this.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');

    document.getElementById('slug').value = slug;
});
</script>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('content');
</script>

@endsection