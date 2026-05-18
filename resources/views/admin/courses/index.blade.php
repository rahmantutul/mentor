@extends('layouts.admin')

@section('styles')
<style>
    .fw-800 { font-weight: 800; }
    .bg-success-light { background: rgba(34, 197, 94, 0.1); }
    .bg-secondary-light { background: rgba(100, 116, 139, 0.1); }
    .h-45 { height: 45px; }
    
    .course-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
    }

    .course-thumbnail-wrapper {
        height: 160px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .course-icon {
        font-size: 3rem;
        color: #cbd5e1;
    }

    .action-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .course-card:hover .action-overlay {
        opacity: 1;
    }

    .btn-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }

    .btn-circle:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 mb-4">
        <div>
            <h1 class="page-title mb-1">Course Library</h1>
            <p class="text-muted small mb-0">Group and organize your video content into structured learning paths.</p>
        </div>
        <button class="btn btn-dark rounded-4 fw-800 px-4 h-45 d-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addCourseModal">
            <i class="bi bi-plus-lg"></i> Create New Course
        </button>
    </div>

    <div class="row g-4">
        @forelse($courses as $course)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card course-card shadow-sm h-100">
                    <div class="course-thumbnail-wrapper">
                        @if($course->thumbnail)
                            <img src="{{ $course->thumbnail }}" class="w-100 h-100 object-fit-cover" alt="{{ $course->title }}">
                        @else
                            <i class="bi bi-collection-play course-icon"></i>
                        @endif
                        
                        <div class="action-overlay">
                            <a href="{{ route('admin.courses.manage', $course) }}" class="btn-circle" title="Manage Lessons">
                                <i class="bi bi-collection-play-fill text-primary"></i>
                            </a>
                            <button class="btn-circle" data-bs-toggle="modal" data-bs-target="#editCourseModal{{ $course->id }}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Delete this course? Videos inside will be unlinked but not deleted.')">
                                @csrf
                                @method('DELETE')
                                <button class="btn-circle text-danger">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-light text-primary rounded-pill px-3 py-1 small fw-bold">{{ $course->category ?? 'General' }}</span>
                            <span class="badge bg-{{ $course->status == 'active' ? 'success' : 'secondary' }}-light text-{{ $course->status == 'active' ? 'success' : 'secondary' }} rounded-pill px-2 py-1 small">
                                {{ ucfirst($course->status) }}
                            </span>
                        </div>
                        <h6 class="fw-800 text-dark mb-2">{{ $course->title }}</h6>
                        <p class="text-muted small mb-3 line-clamp-2">{{ $course->description }}</p>
                        
                        <div class="pt-3 border-top border-light d-flex align-items-center gap-2">
                            <i class="bi bi-play-btn-fill text-muted"></i>
                            <span class="small fw-bold text-muted">{{ $course->contents_count }} Lessons</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Course Modal -->
            <div class="modal fade" id="editCourseModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4 shadow-lg">
                        <div class="modal-header border-0 bg-white pt-4 px-4 pb-2">
                            <h5 class="fw-800 mb-0">Edit Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body px-4 py-4">
                                <div class="mb-3">
                                    <label class="form-label">Course Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <input type="text" name="category" class="form-control" value="{{ $course->category }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Course Thumbnail</label>
                                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                                    @if($course->thumbnail)
                                        <div class="mt-2 small text-muted">Current: {{ basename($course->thumbnail) }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="3" class="form-control">{{ $course->description }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active" {{ $course->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="draft" {{ $course->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer border-0 bg-light py-3 px-4">
                                <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary px-4 rounded-3 fw-800">Update Course</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card border-0 shadow-sm p-5">
                    <i class="bi bi-journal-album text-light mb-3" style="font-size: 3rem;"></i>
                    <h5 class="fw-bold">No courses created yet</h5>
                    <p class="text-muted">Start by creating a course container to organize your lessons.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $courses->links() }}
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 bg-white pt-4 px-4 pb-2">
                <h5 class="fw-800 mb-0">Create New Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body px-4 py-4">
                    <div class="mb-3">
                        <label class="form-label">Course Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Advanced AI Workflow" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control" placeholder="e.g. Productivity">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Course Thumbnail</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="What is this course about?"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light py-3 px-4">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3 fw-800">Create Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
