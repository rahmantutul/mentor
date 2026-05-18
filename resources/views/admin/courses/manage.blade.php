@extends('layouts.admin')

@section('styles')
<style>
    .admin-course-header {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid #f1f5f9;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .admin-lesson-row {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 10px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .admin-lesson-row:hover {
        border-color: #6366f1;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.05);
    }
    .section-divider {
        font-weight: 800;
        font-size: 11px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin: 30px 0 15px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .section-divider::after {
        content: '';
        flex-grow: 1;
        height: 1px;
        background: #f1f5f9;
    }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-1">Manage Course Content</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></li>
                <li class="breadcrumb-item active">{{ $course->title }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.courses.index') }}" class="btn btn-white border-0 shadow-sm rounded-3">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
        <button class="btn btn-primary shadow-sm rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#addVideoModal">
            <i class="bi bi-plus-lg me-2"></i>Add Video to Course
        </button>
    </div>
</div>

<div class="admin-course-header">
    <div class="row align-items-center">
        <div class="col-md-2">
            <img src="{{ $course->thumbnail }}" class="rounded-4 w-100 shadow-sm" style="height: 100px; object-fit: cover;">
        </div>
        <div class="col-md-7">
            <span class="badge bg-primary-subtle text-primary mb-2">{{ $course->category }}</span>
            <h3 class="fw-800 mb-1">{{ $course->title }}</h3>
            <p class="text-muted mb-0 small line-clamp-1">{{ $course->description }}</p>
        </div>
        <div class="col-md-3 text-end">
            <div class="h3 fw-800 mb-0">{{ $course->contents->count() }}</div>
            <div class="text-muted small fw-bold">TOTAL LESSONS</div>
        </div>
    </div>
</div>

<div class="curriculum-manager">
    @forelse($course->grouped_contents as $sectionLabel => $lessons)
        <div class="section-divider">{{ $sectionLabel ?: 'General Lessons' }}</div>
        
        @foreach($lessons as $lesson)
            <div class="admin-lesson-row">
                <div class="d-flex align-items-center gap-3 flex-grow-1">
                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: 800; color: #64748b;">
                        {{ $lesson->sort_order ?: $loop->iteration }}
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">{{ $lesson->title }}</h6>
                        <div class="small text-muted fw-600">
                            {{ $lesson->skill_level }} · {{ $lesson->type }} 
                            @if($lesson->duration_label) · {{ $lesson->duration_label }} @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-white btn-sm rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#editLessonModal{{ $lesson->id }}">
                        <i class="bi bi-pencil-fill text-primary"></i>
                    </button>
                    <form action="{{ route('admin.contents.destroy', $lesson) }}" method="POST" onsubmit="return confirm('Delete this video permanently?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-white btn-sm rounded-3 shadow-sm">
                            <i class="bi bi-trash3-fill text-danger"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Edit Lesson Modal -->
            <div class="modal fade" id="editLessonModal{{ $lesson->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <form action="{{ route('admin.contents.update', $lesson) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-header border-0 p-4 pb-0">
                                <h5 class="fw-800 mb-0">Edit Lesson</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Lesson Title</label>
                                    <input type="text" name="title" value="{{ $lesson->title }}" class="form-control rounded-3" required>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Module/Section</label>
                                        <input type="text" name="section_part_label" value="{{ $lesson->section_part_label }}" class="form-control rounded-3" placeholder="e.g. Module 1">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold">Order (Part #)</label>
                                        <input type="number" name="sort_order" value="{{ $lesson->sort_order }}" class="form-control rounded-3">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label class="form-label small fw-bold">YouTube URL</label>
                                    <input type="url" name="video_url" value="{{ $lesson->video_url }}" class="form-control rounded-3" required>
                                </div>
                                <input type="hidden" name="skill_level" value="{{ $lesson->skill_level }}">
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                            </div>
                            <div class="modal-footer border-0 p-4 pt-0">
                                <button type="button" class="btn btn-light rounded-3 fw-bold" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4">Update Lesson</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @empty
        <div class="text-center py-5 bg-white rounded-4 border border-light">
            <div class="mb-3"><i class="bi bi-camera-video text-muted fs-1"></i></div>
            <h5 class="fw-800">No videos in this course</h5>
            <p class="text-muted small">Start by adding your first lesson below.</p>
        </div>
    @endforelse
</div>

<!-- Add Video Modal -->
<div class="modal fade" id="addVideoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="{{ route('admin.contents.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-800 mb-0">Add New Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Lesson Title</label>
                        <input type="text" name="title" class="form-control rounded-3" placeholder="Introduction to..." required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Module/Section</label>
                            <input type="text" name="section_part_label" class="form-control rounded-3" placeholder="e.g. Module 1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Order (Part #)</label>
                            <input type="number" name="sort_order" class="form-control rounded-3" value="{{ count($course->contents) + 1 }}">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label small fw-bold">YouTube URL</label>
                        <input type="url" name="video_url" class="form-control rounded-3" placeholder="https://youtube.com/..." required>
                    </div>
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="skill_level" value="Beginner">
                    <input type="hidden" name="category" value="{{ $course->category }}">
                    <input type="hidden" name="type" value="video">
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4">Save Lesson</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
