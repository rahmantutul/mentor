@extends('layouts.user')

@section('title', $content->title . ' — CRTVAI')

@section('content')
<div class="watch-page">
    <div class="row g-4">
        <!-- Video Player Column -->
        <div class="col-lg-8">
            <!-- Plyr Player Container -->
            <div class="player-wrapper mb-4">
                <div id="player-wrap">
                    <div id="player"
                         data-plyr-provider="youtube"
                         data-plyr-embed-id="{{ $content->youtube_id }}">
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="watch-progress-bar mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="small fw-bold text-muted">Your progress</span>
                    <span class="small fw-bold" id="progress-label">{{ round($progress->completion_percent) }}%</span>
                </div>
                <div class="progress rounded-pill" style="height: 6px; background: #f1f3f5;">
                    <div class="progress-bar bg-dark rounded-pill" id="progress-bar" style="width: {{ $progress->completion_percent }}%; transition: width 1s ease;"></div>
                </div>
                @if($progress->completed)
                <div class="mt-2 text-success small fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Completed</div>
                @endif
            </div>

            <!-- Video Meta -->
            <div class="video-meta-card p-4 mb-4">
                <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                    <div>
                        <span class="badge bg-light text-dark border me-2 px-3 py-2 rounded-pill fw-bold small">{{ $content->category }}</span>
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold small">{{ $content->skill_level }}</span>
                    </div>
                    @if($content->duration_label)
                    <span class="text-muted small fw-bold"><i class="bi bi-clock me-1"></i>{{ $content->duration_label }}</span>
                    @endif
                </div>
                <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                    <h1 class="h4 fw-bold mb-0" style="line-height: 1.35; color:#000;">{{ $content->title }}</h1>
                    <button class="btn btn-bookmark {{ Auth::user()->bookmarkedContents()->where('content_id', $content->id)->exists() ? 'active' : '' }}" 
                            onclick="toggleBookmark({{ $content->id }}, this)" 
                            title="Bookmark this video">
                        <i class="bi {{ Auth::user()->bookmarkedContents()->where('content_id', $content->id)->exists() ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
                    </button>
                </div>
                @if($content->description)
                <p class="text-muted mb-0" style="line-height: 1.7;">{{ $content->description }}</p>
                @endif
                @if($content->tags)
                <div class="mt-3 d-flex flex-wrap gap-2">
                    @foreach(array_map('trim', explode(',', $content->tags)) as $tag)
                        @if($tag)
                        <span class="badge bg-light text-secondary border px-2 py-1 small">{{ $tag }}</span>
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar: Curriculum or Up Next -->
        <div class="col-lg-4">
            <div class="sidebar-section">
                @if($course)
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="card-header bg-dark text-white py-3 px-4">
                            <h6 class="fw-bold mb-1">Course Curriculum</h6>
                            <div class="small opacity-75">{{ $course->title }}</div>
                        </div>
                        <div class="card-body p-0">
                            <div class="accordion accordion-flush" id="curriculumAccordion">
                                @foreach($course->grouped_contents as $sectionLabel => $lessons)
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button py-3 px-4 fw-bold small text-uppercase letter-spacing-1 {{ $content->section_part_label != $sectionLabel ? 'collapsed' : '' }}" 
                                                    type="button" data-bs-toggle="collapse" data-bs-target="#section-{{ Str::slug($sectionLabel ?: 'general') }}">
                                                {{ $sectionLabel ?: 'General' }}
                                            </button>
                                        </h2>
                                        <div id="section-{{ Str::slug($sectionLabel ?: 'general') }}" 
                                             class="accordion-collapse collapse {{ $content->section_part_label == $sectionLabel ? 'show' : '' }}" 
                                             data-bs-parent="#curriculumAccordion">
                                            <div class="accordion-body p-0">
                                                @foreach($lessons as $lesson)
                                                    <a href="{{ route('learn.watch', $lesson) }}" 
                                                       class="curriculum-item d-flex align-items-center gap-3 py-3 px-4 text-decoration-none {{ $lesson->id == $content->id ? 'active' : '' }}">
                                                        <div class="lesson-num-circle">
                                                            @if($lesson->id == $content->id)
                                                                <i class="bi bi-play-fill"></i>
                                                            @else
                                                                {{ $loop->iteration }}
                                                            @endif
                                                        </div>
                                                        <div class="overflow-hidden">
                                                            <div class="fw-bold small line-clamp-2">{{ $lesson->title }}</div>
                                                            <div class="text-muted" style="font-size:10px;">
                                                                Part {{ $lesson->sort_order }} · {{ $lesson->duration_label ?: '5m' }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <h6 class="fw-bold mb-3" style="color:#000; letter-spacing:-0.02em;">Up Next</h6>
                    <div class="d-flex flex-column gap-3">
                        @foreach($recommended as $rec)
                        <a href="{{ route('learn.watch', $rec) }}" class="next-video-card text-decoration-none">
                            <div class="d-flex gap-3 align-items-center">
                                <div class="next-thumb flex-shrink-0">
                                    <img src="{{ $rec->thumbnail_url }}" alt="{{ $rec->title }}">
                                    <div class="next-play"><i class="bi bi-play-fill"></i></div>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-bold small text-dark line-clamp-2">{{ $rec->title }}</div>
                                    <div class="text-muted" style="font-size:11px; margin-top:4px;">{{ $rec->category }} · {{ $rec->skill_level }}</div>
                                    @if($rec->duration_label)
                                    <div class="text-muted" style="font-size:10px;"><i class="bi bi-clock me-1"></i>{{ $rec->duration_label }}</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Plyr CSS -->
@section('styles')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css">
<style>
    .watch-page { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

    /* Plyr Player Wrapper */
    .player-wrapper {
        position: relative;
        background: #000;
        border-radius: 20px;
        overflow: hidden;
        aspect-ratio: 16 / 9;
    }
    .player-wrapper #player-wrap,
    .player-wrapper .plyr,
    .player-wrapper .plyr__video-wrapper,
    .player-wrapper iframe {
        width: 100% !important;
        height: 100% !important;
        border-radius: 0;
    }

    /* Plyr theme customization — pure dark, no YouTube feel */
    :root {
        --plyr-color-main: #6366f1;
        --plyr-range-fill-background: #6366f1;
        --plyr-video-background: #000;
        --plyr-menu-background: #1e293b;
        --plyr-menu-color: #f8fafc;
        --plyr-tooltip-background: #1e293b;
        --plyr-tooltip-color: #f8fafc;
        --plyr-font-family: 'Inter', sans-serif;
        --plyr-control-icon-size: 18px;
        --plyr-control-spacing: 10px;
    }
    .plyr--video .plyr__controls {
        background: linear-gradient(transparent, rgba(0,0,0,0.85)) !important;
        padding: 20px 16px 14px !important;
    }
    /* Hide the large centered overlay play button — we only use the control bar */
    .plyr__control--overlaid { display: none !important; }

    .video-meta-card {
        background: #fff;
        border: 1px solid #f1f3f5;
        border-radius: 16px;
    }

    /* Next videos */
    .next-video-card {
        padding: 12px;
        border-radius: 14px;
        border: 1px solid #f1f3f5;
        background: #fff;
        transition: all 0.2s;
    }
    .next-video-card:hover {
        border-color: #000;
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .next-thumb {
        position: relative;
        width: 90px;
        height: 58px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .next-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .next-play {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .next-video-card:hover .next-play { opacity: 1; }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .sidebar-section { position: sticky; top: 90px; }

    /* Curriculum Sidebar */
    .curriculum-item {
        color: #475569;
        transition: all 0.2s;
        border-bottom: 1px solid #f8fafc;
    }
    .curriculum-item:hover { background: #f8fafc; color: #6366f1; }
    .curriculum-item.active {
        background: rgba(99, 102, 241, 0.05);
        color: #6366f1;
        border-left: 3px solid #6366f1;
    }
    .lesson-num-circle {
        width: 28px; height: 28px;
        border-radius: 8px;
        background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; flex-shrink: 0;
    }
    .curriculum-item.active .lesson-num-circle { background: #6366f1; color: #fff; }
    .accordion-button:not(.collapsed) { background: #fff; color: #000; box-shadow: none; }
    .accordion-button:focus { box-shadow: none; border-color: rgba(0,0,0,0.1); }
    .letter-spacing-1 { letter-spacing: 1px; }

    /* Bookmark Button */
    .btn-bookmark {
        width: 42px; height: 42px;
        border-radius: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem; color: #64748b;
        transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .btn-bookmark:hover { background: #fff; border-color: #000; color: #000; transform: scale(1.05); }
    .btn-bookmark.active { background: #000; border-color: #000; color: #fff; }
    .btn-bookmark.active:hover { background: #334155; border-color: #334155; }
</style>
@endsection

@section('scripts')
<!-- Plyr JS -->
<script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
<script>
    const contentId    = {{ $content->id }};
    const savedSeconds = {{ (int) $progress->watched_seconds }};
    const saveUrl      = "{{ route('learn.progress.save') }}";
    const csrfToken    = "{{ csrf_token() }}";

    // Initialize Plyr with YouTube provider
    const player = new Plyr('#player', {
        youtube: {
            noCookie: true,           // Use youtube-nocookie.com
            rel: 0,
            showinfo: 0,
            iv_load_policy: 3,
            modestbranding: 1,
            controls: 0,             // IMPORTANT: hide YouTube's own controls & play button
            disablekb: 1,            // Disable YouTube keyboard shortcuts
        },
        controls: [
            'play',
            'progress',
            'current-time',
            'duration',
            'mute',
            'volume',
            'settings',
            'fullscreen',
        ],
        settings: ['speed'],
        hideControls: true,
        resetOnEnd: false,
        clickToPlay: true,
        keyboard: { focused: true, global: false },
        tooltips: { controls: true, seek: true },
        captions: { active: false },
    });

    // Seek to saved position once player is ready
    player.on('ready', () => {
        if (savedSeconds > 10) {
            player.currentTime = savedSeconds - 5;
        }
        // Start saving every 10s
        setInterval(saveProgress, 10000);
    });

    // Save when paused or ended
    player.on('pause', () => saveProgress());
    player.on('ended', () => saveProgress(true));
    window.addEventListener('beforeunload', () => saveProgress());

    function saveProgress(forceComplete = false) {
        const duration = player.duration || 0;
        if (duration < 1) return;
        const watched = forceComplete ? Math.floor(duration) : Math.floor(player.currentTime);

        fetch(saveUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ content_id: contentId, watched_seconds: watched, duration_seconds: Math.floor(duration) })
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('progress-bar').style.width = data.completion_percent + '%';
            document.getElementById('progress-label').textContent = Math.round(data.completion_percent) + '%';
        });
    }

    function toggleBookmark(contentId, btn) {
        const icon = btn.querySelector('i');
        fetch(`/bookmarks/${contentId}/toggle`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'added') {
                btn.classList.add('active');
                icon.classList.replace('bi-bookmark', 'bi-bookmark-fill');
                showToast('Video added to bookmarks!', 'success');
            } else {
                btn.classList.remove('active');
                icon.classList.replace('bi-bookmark-fill', 'bi-bookmark');
                showToast('Video removed from bookmarks', 'info');
            }
            btn.style.transform = 'scale(1.2)';
            setTimeout(() => { btn.style.transform = ''; }, 200);
        });
    }
</script>
@endsection
