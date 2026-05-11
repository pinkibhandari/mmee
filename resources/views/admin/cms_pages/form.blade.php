@extends('admin.layouts.app')

@section('title', $page->id ? 'Edit Page' : 'Create Page')

@section('content')

    <div class="card shadow mb-4 border-0">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center py-3">

            <h6 class="mb-0">
                <strong>
                    {{ $page->id ? 'Edit CMS Page' : 'Create CMS Page' }}
                </strong>
            </h6>

            <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-sm btn-secondary">

                Back

            </a>

        </div>

        <!-- Body -->
        <div class="card-body">

            <form id="cmsPageForm" method="POST"
                action="{{ $page->id ? route('admin.cms-pages.update', $page->id) : route('admin.cms-pages.store') }}">

                @csrf

                @if ($page->id)
                    @method('PUT')
                @endif

                <div class="row g-3">

                    <!-- Title -->
                    <div class="col-lg-4 col-md-6 col-12">

                        <label class="form-label fw-semibold">
                            Page Title
                        </label>

                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror" placeholder="Enter page title"
                            value="{{ old('title', $page->title) }}">

                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <!-- Slug -->
                    <!-- <div class="col-lg-4 col-md-6 col-12">

                        <label class="form-label fw-semibold">
                            Slug
                        </label>

                        <input type="text" name="slug" id="slug"
                            class="form-control @error('slug') is-invalid @enderror" placeholder="Enter slug"
                            value="{{ old('slug', $page->slug) }}">

                        @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div> -->

                    <!-- Status -->
                    <div class="col-lg-4 col-md-6 col-12">

                        <label class="form-label fw-semibold">
                            Status
                        </label>
                        <br>

                        <select name="status" class="form-select @error('status') is-invalid @enderror">

                            <option value="">
                                Select Status
                            </option>

                            <option value="1" {{ old('status', $page->status) == 1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ old('status', $page->status) == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                  

                    <!-- Content -->
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Content
                        </label>
                        <!-- Quill Editor -->
                        <div id="editor" style="height:250px;">   
                        </div>
                        <input type="hidden" name="content" id="editor-content" value="{{ old('content', $page->content) }}">
                        @error('content')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>

                <!-- Submit -->
                <div class="mt-4">

                    <button type="submit" class="btn btn-primary px-4">

                        {{ $page->id ? 'Update Page' : 'Save Page' }}

                    </button>

                </div>

            </form>

        </div>

    </div>
    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

  <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Quill
            var quill = new Quill('#editor', {
                theme: 'snow',
                placeholder: 'Write page content here...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'image']
                    ]
                }
            });

            // Load old/existing content
            var contentInput = document.getElementById('editor-content');
            //  console.log('Existing content:', contentInput.value);
            if (contentInput.value) {
                quill.root.innerHTML = contentInput.value;
            }

            // On form submit, update hidden input
            var form = document.getElementById('cmsPageForm');
            form.addEventListener('submit', function() {
                contentInput.value = quill.root.innerHTML.trim();
                //  console.log('Existing content:', contentInput.value);
            });
        });
    </script>
@endsection
