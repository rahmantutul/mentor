@extends('layouts.user')

@section('title', 'Dashboard — CRTVAI')

@section('content')
<div class="dashboard-focus-modern">
    <!-- Top Row: Welcome Hero & Stats -->
    <div class="row g-5 mb-5">
        <div class="col-xl-8">
            <div class="hero-focus-card shadow-lg animate-slide-up">
                <div class="row align-items-center h-100">
                    <div class="col-lg-7 p-4 p-xl-5">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <span class="focus-pill-tag" style="background: #000;">PRIMARY LEARNING GOAL</span>
                            <span class="text-muted fw-800 small opacity-75">{{ date('M d, Y') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="fw-800 mb-0" style="font-size: 36px; letter-spacing: -0.05em; color: #000;">{{ Str::limit(auth()->user()->learning_goal ?? 'Set Your Goal', 25) }}</h1>
                            <div class="d-flex gap-2">
                                <button class="swiper-prev-recommended btn btn-light rounded-circle p-0 shadow-sm" style="width: 32px; height: 32px; border: 1px solid #eee;">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button class="swiper-next-recommended btn btn-light rounded-circle p-0 shadow-sm" style="width: 32px; height: 32px; border: 1px solid #eee;">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-dark opacity-75 mb-5 fw-600 fs-5" style="line-height: 1.5;">Your high-velocity roadmap to the tech industry. Master high-demand skills and build a professional-grade portfolio with AI-driven precision.</p>
                        
                        <!-- Recommendation Slider (Each slide is a full card) -->
                        <div class="swiper recommendedSwiper">
                            <div class="swiper-wrapper">
                                @foreach($recommended as $content)
                                <div class="swiper-slide">
                                    <div class="recom-focus-card rounded-4 p-4 shadow-sm border border-light bg-white">
                                        <div class="d-flex gap-4">
                                            <div class="recom-thumb-focus rounded-4 shadow-sm overflow-hidden" style="width: 130px; height: 130px; flex-shrink: 0;">
                                                <img src="{{ $content->thumbnail_url }}" class="w-100 h-100 object-fit-cover">
                                                <div class="recom-play-overlay"><i class="bi bi-play-fill"></i></div>
                                            </div>
                                            <div class="flex-grow-1 d-flex flex-column justify-content-center">
                                                <div class="text-primary fw-900 mb-1" style="font-size: 10px; letter-spacing: 0.1em;">START MASTERCLASS</div>
                                                <h5 class="fw-800 text-dark mb-3 line-clamp-2" style="font-size: 18px; letter-spacing: -0.02em;">{{ $content->title }}</h5>
                                                <a href="{{ route('learn.watch', $content) }}" class="btn-focus-link">
                                                    Begin Learning Now <i class="bi bi-chevron-right ms-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block text-end pe-5">
                        <img src="{{ asset('images/dashboard/hero.png') }}" class="img-fluid floating-hero-img" style="max-height: 320px;" alt="Learning Illustration">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="stats-focus-container d-flex flex-column gap-3 h-100">
                <div class="stat-focus-card shadow-sm p-4 animate-slide-up delay-1">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon-square bg-blue text-blue">
                            <i class="bi bi-collection-play-fill"></i>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small fw-800 mb-1">VIDEOS COMPLETED</div>
                            <div class="h2 fw-800 mb-0">{{ $completedCount }}</div>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-light">
                        <div class="d-flex justify-content-between small fw-700">
                            <span class="text-muted">In Progress</span>
                            <span class="text-dark">{{ $inProgressCount }} Modules</span>
                        </div>
                    </div>
                </div>
                <div class="stat-focus-card shadow-sm p-4 animate-slide-up delay-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon-square bg-sky text-sky">
                            <i class="bi bi-fire"></i>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small fw-800 mb-1">ACTIVE STREAK</div>
                            <div class="h2 fw-800 mb-0">{{ auth()->user()->streak_count }} <span class="small fw-700 opacity-50" style="font-size: 14px;">days</span></div>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-light">
                        <div class="progress rounded-pill" style="height: 6px; background: #f1f5f9;">
                            <div class="progress-bar bg-sky" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
                <div class="stat-focus-card shadow-sm p-4 animate-slide-up delay-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="stat-icon-square bg-teal text-teal">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small fw-800 mb-1">TOTAL TIME</div>
                            <div class="h2 fw-800 mb-0">{{ round($totalWatchSeconds / 3600, 1) }} <span class="small fw-700 opacity-50" style="font-size: 14px;">hrs</span></div>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top border-light">
                        <div class="text-teal small fw-800"><i class="bi bi-graph-up-arrow me-1"></i> +12% this week</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($continueWatching->count() > 0)
    <!-- Continue Watching Row -->
    <div class="mb-5 animate-slide-up delay-4 px-4 py-5 rounded-5" style="background: #eef2ff; border: 1px solid #f1f5f9;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-800 mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-play-circle-fill text-primary"></i> Continue Watching
            </h5>
            <div class="d-flex align-items-center gap-3">
                <a href="#" class="text-muted fw-800 small text-decoration-none d-none d-md-block">History</a>
                <div class="d-flex gap-2">
                    <button class="swiper-prev-watching btn btn-light rounded-circle shadow-sm p-0" style="width: 32px; height: 32px; border: 1px solid #eee;">
                        <i class="bi bi-chevron-left" style="font-size: 12px;"></i>
                    </button>
                    <button class="swiper-next-watching btn btn-light rounded-circle shadow-sm p-0" style="width: 32px; height: 32px; border: 1px solid #eee;">
                        <i class="bi bi-chevron-right" style="font-size: 12px;"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="swiper continueWatchingSwiper">
            <div class="swiper-wrapper">
                @foreach($continueWatching as $progress)
                <div class="swiper-slide">
                    <div class="card-focus p-3 d-flex gap-3 align-items-center h-100">
                        <div class="rounded-3 overflow-hidden shadow-sm" style="width: 80px; height: 60px; flex-shrink: 0;">
                            <img src="{{ $progress->content->thumbnail_url }}" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <h6 class="fw-800 text-dark mb-1 line-clamp-1" style="font-size: 13px;" title="{{ $progress->content->title }}">{{ Str::limit($progress->content->title, 30) }}</h6>
                            <div class="progress rounded-pill mb-1" style="height: 4px; background: #f1f5f9;">
                                <div class="progress-bar bg-primary" style="width: {{ $progress->completion_percent }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted fw-800" style="font-size: 9px;">{{ $progress->completion_percent }}% COMPLETE</span>
                                <a href="{{ route('learn.watch', $progress->content) }}" class="text-primary fw-800 small text-decoration-none" style="font-size: 10px;">RESUME <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Learning Goals Section -->
    <div class="mb-5 animate-slide-up delay-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-800 mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-compass-fill text-primary"></i> Choose Your Learning Path
            </h5>
            <div class="d-flex gap-2">
                <button class="swiper-prev-tracks btn btn-light rounded-circle shadow-sm p-0" style="width: 32px; height: 32px; border: 1px solid #eee;">
                    <i class="bi bi-chevron-left" style="font-size: 12px;"></i>
                </button>
                <button class="swiper-next-tracks btn btn-light rounded-circle shadow-sm p-0" style="width: 32px; height: 32px; border: 1px solid #eee;">
                    <i class="bi bi-chevron-right" style="font-size: 12px;"></i>
                </button>
            </div>
        </div>
        
        <div class="swiper tracksSwiper">
            <div class="swiper-wrapper">
                @php
                    $goals = [
                        'Get a job in tech' => ['icon' => 'bi-briefcase', 'img' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?q=80&w=1974&auto=format&fit=crop', 'desc' => 'Career Acceleration'],
                        'Build a side project' => ['icon' => 'bi-rocket-takeoff', 'img' => 'https://images.unsplash.com/photo-1559136555-9303baea8ebd?q=80&w=2070&auto=format&fit=crop', 'desc' => 'Founder Curriculum'],
                        'Improve skills at work' => ['icon' => 'bi-graph-up-arrow', 'img' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop', 'desc' => 'Professional Growth'],
                        'Explore AI tools' => ['icon' => 'bi-magic', 'img' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?q=80&w=2070&auto=format&fit=crop', 'desc' => 'Innovation Track'],
                        'Learn to code' => ['icon' => 'bi-terminal', 'img' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?q=80&w=2070&auto=format&fit=crop', 'desc' => 'Core Development'],
                    ];
                @endphp
                @foreach($goals as $name => $data)
                <div class="swiper-slide">
                    <a href="{{ route('learn.explore', ['goal' => $name]) }}" class="text-decoration-none h-100 d-block">
                        <div class="card-focus overflow-hidden h-100 transition-all hover-lift">
                            <div class="position-relative" style="height: 140px;">
                                <img src="{{ $data['img'] }}" class="w-100 h-100 object-fit-cover">
                                <div class="position-absolute top-0 start-0 m-3">
                                    <div class="bg-white rounded-3 p-2 shadow-sm"><i class="bi {{ $data['icon'] }} text-primary"></i></div>
                                </div>
                            </div>
                            <div class="p-4">
                                <h6 class="fw-800 text-dark mb-1">{{ $name }}</h6>
                                <p class="text-muted small fw-600 mb-0">{{ $data['desc'] }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Recommended Courses Grid -->

    <!-- Shorts Grid -->
    @if($shorts->count() > 0)
    <div class="mb-5 animate-slide-up delay-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-800 mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-lightning-fill text-sky"></i> Learning Shorts
            </h5>
            <div class="d-flex align-items-center gap-3">
                <a href="#" class="text-muted fw-800 small text-decoration-none d-none d-md-block">View all</a>
                <div class="d-flex gap-2">
                    <button class="swiper-prev-shorts btn btn-light rounded-circle shadow-sm p-0" style="width: 32px; height: 32px; border: 1px solid #eee;">
                        <i class="bi bi-chevron-left" style="font-size: 12px;"></i>
                    </button>
                    <button class="swiper-next-shorts btn btn-light rounded-circle shadow-sm p-0" style="width: 32px; height: 32px; border: 1px solid #eee;">
                        <i class="bi bi-chevron-right" style="font-size: 12px;"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="swiper shortsSwiper">
            <div class="swiper-wrapper">
                @foreach($shorts as $short)
                <div class="swiper-slide">
                    <div class="short-card-focus rounded-4 overflow-hidden position-relative shadow-sm" style="height: 240px;">
                        <img src="{{ $short->thumbnail_url }}" class="w-100 h-100 object-fit-cover">
                        <div class="short-overlay-focus">
                            <h6 class="text-white fw-800 mb-2 line-clamp-2" style="font-size: 11px;">{{ $short->title }}</h6>
                            <a href="{{ route('learn.watch', $short) }}" class="btn-short-play"><i class="bi bi-play-fill"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Courses Row -->
    @if($courses->count() > 0)
    <div class="mb-5 animate-slide-up delay-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-800 mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-collection-play-fill text-primary"></i> Masterclasses & Courses
            </h5>
            <div class="d-flex align-items-center gap-2">
                <button class="swiper-prev-courses btn btn-light rounded-circle shadow-sm p-0" style="width: 32px; height: 32px; border: 1px solid #eee;">
                    <i class="bi bi-chevron-left" style="font-size: 12px;"></i>
                </button>
                <button class="swiper-next-courses btn btn-light rounded-circle shadow-sm p-0" style="width: 32px; height: 32px; border: 1px solid #eee;">
                    <i class="bi bi-chevron-right" style="font-size: 12px;"></i>
                </button>
            </div>
        </div>
        
        <div class="swiper coursesSwiper">
            <div class="swiper-wrapper">
                @foreach($courses as $course)
                <div class="swiper-slide">
                    <a href="{{ route('course.view', $course) }}" class="text-decoration-none h-100 d-block">
                        <div class="card-focus overflow-hidden h-100 transition-all hover-lift">
                            <div class="position-relative" style="height: 160px;">
                                <img src="{{ $course->thumbnail }}" class="w-100 h-100 object-fit-cover">
                                <div class="position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-bold small shadow-sm">{{ $course->category }}</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <h6 class="fw-800 text-dark mb-2 line-clamp-2">{{ $course->title }}</h6>
                                <div class="d-flex align-items-center gap-2 text-muted small fw-bold">
                                    <i class="bi bi-play-btn-fill"></i>
                                    {{ $course->contents_count ?? $course->contents->count() }} Lessons
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Middle Grid: Career Readiness & Trending -->
    <div class="row mb-5" style="background: #f8fafc; padding: 20px; border-radius: 20px;">
        <div class="col-lg-6">
            <div class="card-focus shadow-sm h-100 animate-slide-up delay-5 border-0" style="background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);">
                <div class="d-flex justify-content-between align-items-center p-4">
                    <h5 class="fw-800 mb-0 d-flex align-items-center gap-3">
                        <div class="icon-focus-circle" style="width: 40px; height: 40px; background: #eff6ff; color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-trophy-fill"></i></div>
                        AI Career Readiness
                    </h5>
                    <a href="#" class="btn-text-focus text-decoration-none fw-800 text-primary small">Optimize Path</a>
                </div>
                <div class="p-4">
                    @php
                        // Calculate readiness based on primary category
                        $topCat = \App\Models\Content::select('category')
                            ->whereIn('id', auth()->user()->videoProgress()->pluck('content_id'))
                            ->groupBy('category')
                            ->orderByRaw('COUNT(*) DESC')
                            ->first()?->category ?? 'General AI';
                        
                        $totalInCat = \App\Models\Content::where('category', $topCat)->count();
                        $compInCat = auth()->user()->videoProgress()
                            ->whereHas('content', fn($q) => $q->where('category', $topCat))
                            ->where('completed', true)
                            ->count();
                        
                        $readiness = $totalInCat > 0 ? round(($compInCat / $totalInCat) * 100) : 0;
                        // Add some logic to ensure it's not 0 for new users for UI demo
                        $readiness = max($readiness, 15); 
                    @endphp
                    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <h4 class="fw-900 text-dark mb-1">{{ $readiness }}%</h4>
                            <p class="text-muted small fw-700 mb-0">Junior {{ $topCat }} Roles</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-800" style="font-size: 10px;">ON TRACK</span>
                        </div>
                    </div>
                    
                    <div class="progress rounded-pill mb-4" style="height: 12px; background: #f1f5f9; border: 1px solid #e2e8f0;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: {{ $readiness }}%"></div>
                    </div>
                    
                    <div class="p-3 bg-light rounded-4 border border-light">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="flex-shrink-0 bg-white rounded-3 p-2 shadow-sm"><i class="bi bi-lightning-charge-fill text-warning"></i></div>
                            <div>
                                <h6 class="fw-800 text-dark mb-1" style="font-size: 13px;">Next Milestone</h6>
                                <p class="text-muted mb-0" style="font-size: 11px; font-weight: 600;">Complete 3 more modules in <strong>{{ $topCat }}</strong> to reach 80% readiness.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-focus shadow-sm h-100 animate-slide-up delay-5 border-0" style="background: linear-gradient(135deg, #ffffff 0%, #f8faff 100%);">
                <div class="d-flex justify-content-between align-items-center p-4">
                    <h5 class="fw-800 mb-0 d-flex align-items-center gap-3">
                        <div class="icon-focus-circle" style="width: 40px; height: 40px; background: #fff1f2; color: #e11d48; border-radius: 12px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-fire"></i></div>
                        Trending Categories
                    </h5>
                    <a href="{{ route('learn.explore') }}" class="btn-text-focus text-decoration-none fw-800 text-primary small">Explore All</a>
                </div>
                <div class="px-4 pb-4">
                    @php
                        $trendingCategories = \App\Models\Content::select('category', \DB::raw('count(*) as count'))
                            ->groupBy('category')
                            ->orderByDesc('count')
                            ->limit(4)
                            ->get();
                        
                        $catStyles = [
                            'AI' => ['icon' => 'bi-cpu', 'bg' => '#eef2ff', 'text' => '#4f46e5'],
                            'Design' => ['icon' => 'bi-palette', 'bg' => '#fff7ed', 'text' => '#ea580c'],
                            'Development' => ['icon' => 'bi-code-slash', 'bg' => '#f0fdf4', 'text' => '#16a34a'],
                            'Business' => ['icon' => 'bi-briefcase', 'bg' => '#faf5ff', 'text' => '#9333ea'],
                            'General' => ['icon' => 'bi-grid', 'bg' => '#f0f9ff', 'text' => '#0284c7']
                        ];
                    @endphp
                    
                    <div class="row g-3">
                        @foreach($trendingCategories as $cat)
                        @php 
                            $style = $catStyles[$cat->category] ?? $catStyles['General'];
                        @endphp
                        <div class="col-6">
                            <a href="{{ route('learn.explore', ['category' => $cat->category]) }}" class="cat-card-neo p-3 rounded-4 border border-light bg-white d-block text-decoration-none transition-all">
                                <div class="d-flex flex-column gap-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="cat-icon-box" style="width: 38px; height: 38px; background: {{ $style['bg'] }}; color: {{ $style['text'] }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                            <i class="bi {{ $style['icon'] }}"></i>
                                        </div>
                                        <span class="badge bg-light text-dark border rounded-pill fw-800" style="font-size: 9px;">{{ $cat->count }}</span>
                                    </div>
                                    <div>
                                        <h6 class="fw-800 text-dark mb-0" style="font-size: 14px;">{{ $cat->category }}</h6>
                                        <p class="text-muted mb-0" style="font-size: 10px; font-weight: 600;">Interactive Hub</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Quotes Slider Footer (Preserving Original Design & Static Image) -->
    <div class="practice-footer-focus rounded-5 shadow-2xl p-5 mb-5 border-0 animate-slide-up delay-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-4 text-center">
                <div class="badge-icon-focus mx-auto mb-4"><i class="bi bi-quote"></i></div>
                <h2 class="fw-800 text-dark mb-3" style="font-size: 32px; letter-spacing: -0.04em;">Industry Insights</h2>
                <p class="text-dark opacity-75 fw-600 mb-0 fs-6">Stay inspired by the visionaries shaping the future of artificial intelligence and technology.</p>
            </div>
            <div class="col-lg-8">
                <div class="interview-preview-card bg-white rounded-5 shadow-sm p-4 h-100">
                    <div class="row align-items-center h-100">
                        <div class="col-md-5">
                            <div class="position-relative h-100">
                                <img src="{{ asset('images/dashboard/interview.png') }}" class="img-fluid rounded-5 shadow-sm object-fit-cover" style="height: 280px; width: 100%;">
                                <div class="interview-live-badge"><span class="pulse-dot"></span> DAILY INSIGHTS</div>
                            </div>
                        </div>
                        <div class="col-md-7 p-4">
                            <div class="swiper quotesSwiper">
                                <div class="swiper-wrapper">
                                    @php
                                        $quotes = [
                                            ['text' => "AI is probably the most important thing humanity has ever worked on.", 'author' => "Sundar Pichai", 'title' => "CEO, Google"],
                                            ['text' => "People who use AI will replace people who don't.", 'author' => "Jensen Huang", 'title' => "CEO, NVIDIA"],
                                            ['text' => "The advance of AI is not going to stop. Training yourself to work with it is critical.", 'author' => "Satya Nadella", 'title' => "CEO, Microsoft"],
                                            ['text' => "AI won't replace humans — but humans with AI will replace humans without AI.", 'author' => "Tech Insight", 'title' => "Industry Common Proverb"],
                                            ['text' => "The future belongs to those who learn more skills and combine them in creative ways.", 'author' => "Robert Greene", 'title' => "Author & Strategist"]
                                        ];
                                    @endphp
                                    
                                    @foreach($quotes as $quote)
                                    <div class="swiper-slide">
                                        <h5 class="fw-800 text-dark mb-3" style="line-height: 1.4; font-size: 20px;">"{{ $quote['text'] }}"</h5>
                                        <div class="d-flex align-items-center gap-2 mb-4">
                                            <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-1 fw-800" style="font-size: 10px;">{{ strtoupper($quote['author']) }}</div>
                                            <span class="text-muted fw-bold small">• {{ $quote['title'] }}</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-4 mb-4">
                                            <div class="text-center">
                                                <div class="fw-900 text-dark h6 mb-0">AI</div>
                                                <div class="text-muted fw-800" style="font-size: 9px;">CATEGORY</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="fw-900 text-dark h6 mb-0">Daily</div>
                                                <div class="text-muted fw-800" style="font-size: 9px;">FREQUENCY</div>
                                            </div>
                                        </div>
                                        <button class="btn btn-link text-primary p-0 fw-900 text-decoration-none">Learn More <i class="bi bi-arrow-right"></i></button>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination quotes-pagination mt-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    :root {
        --focus-primary: #4f46e5;
        --focus-bg: #ffffff;
        --focus-text: #020617;
        --focus-border: #e2e8f0;
        --focus-shadow: 0 20px 50px -15px rgba(0, 0, 0, 0.08);
    }

    .text-dark { color: #334155 !important; } /* Soft Slate 700 */
    .fw-800.text-dark, .fw-900.text-dark { color: #474a4e !important; } /* Deeper Slate 800 for headings */

    .dashboard-focus-modern { background-color: var(--focus-bg); }

    /* Typography */
    .fw-800 { font-weight: 800; }
    .fw-900 { font-weight: 900; }
    .ls-2 { letter-spacing: 0.15em; }

    /* Line Clamp Utilities */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Hero Card */
    .hero-focus-card {
        background: #eef2ff;
        border-radius: 40px;
        border: 1px solid #e0e7ff;
        overflow: hidden;
    }
    .focus-pill-tag {
        background: var(--focus-primary); color: #fff; font-size: 10px; font-weight: 900;
        padding: 5px 12px; border-radius: 8px; letter-spacing: 0.1em;
    }

    .recom-focus-card { background: #fff; transition: 0.3s; }
    .recom-thumb-focus { position: relative; background: #000; }
    .recom-thumb-focus img { 
        transition: 0.5s ease; 
        filter: brightness(0.85) saturate(0.8); 
    }
    .recom-focus-card:hover .recom-thumb-focus img { 
        filter: brightness(1.1) saturate(1.1); 
    }
    .recom-play-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.2);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 24px; opacity: 0; transition: 0.3s;
    }
    .recom-focus-card:hover { transform: translateY(-5px); border-color: var(--focus-primary); }
    .recom-focus-card:hover .recom-play-overlay { opacity: 1; }

    .btn-focus-link {
        color: var(--focus-primary); font-weight: 900; text-decoration: none;
        font-size: 14px; display: inline-flex; align-items: center;
    }
    .btn-focus-link:hover { transform: translateX(5px); }

    /* Stats */
    .stat-focus-card { background: #fff; border: 1px solid var(--focus-border); border-radius: 24px; transition: 0.3s; }
    .stat-focus-card:hover { border-color: var(--focus-primary); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
    .stat-icon-square {
        width: 52px; height: 52px; border-radius: 16px; display: flex;
        align-items: center; justify-content: center; font-size: 24px;
    }
    .bg-sky { background: #f0f9ff; color: #0369a1; }
    .bg-blue { background: #eff6ff; color: #2563eb; }
    .bg-teal { background: #f0fdfa; color: #0d9488; }

    /* Shorts */
    .short-card-focus { transition: 0.3s; background: #000; }
    .short-card-focus img { 
        transition: 0.5s ease; 
        filter: brightness(0.8) grayscale(0.2); 
    }
    .short-card-focus:hover img { 
        filter: brightness(1.1) grayscale(0); 
        transform: scale(1.1); 
    }
    .short-card-focus:hover { transform: scale(1.05); z-index: 10; }
    .short-overlay-focus {
        position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        padding: 15px; display: flex; flex-direction: column; justify-content: flex-end;
    }
    .btn-short-play {
        width: 32px; height: 32px; background: #fff; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; color: #000;
        font-size: 16px; text-decoration: none; align-self: flex-end; transition: 0.2s;
    }
    .btn-short-play:hover { background: var(--focus-primary); color: #fff; }

    /* Cards & Grids */
    .card-focus { background: #fff; border: 1px solid var(--focus-border); border-radius: 24px; transition: 0.3s; }
    .course-card-focus { background: #fff; border: 1px solid var(--focus-border); border-radius: 32px; overflow: hidden; transition: 0.3s; }
    .course-card-focus:hover { transform: translateY(-10px); border-color: var(--focus-primary); box-shadow: var(--focus-shadow); }
    .course-thumb-focus { height: 180px; background: #000; }
    .course-thumb-focus img { 
        transition: 0.5s cubic-bezier(0.4, 0, 0.2, 1); 
        filter: brightness(0.85) saturate(0.8);
        opacity: 0.9;
    }
    .course-card-focus:hover .course-thumb-focus img { 
        filter: brightness(1.1) saturate(1.1) scale(1.05); 
        opacity: 1;
    }
    .thumb-badge-focus {
        position: absolute; top: 15px; left: 15px; color: #fff; font-weight: 900;
        font-size: 9px; padding: 5px 12px; border-radius: 8px; letter-spacing: 0.05em;
    }
    .badge-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }

    /* Practice Footer */
    .practice-footer-focus { background: #f8fafc; border: 1px solid var(--focus-border); }
    .badge-icon-focus {
        width: 64px; height: 64px; background: #000; color: #fff;
        border-radius: 20px; display: flex; align-items: center; justify-content: center;
        font-size: 32px; margin: 0 auto;
    }
    .interview-live-badge {
        position: absolute; top: 15px; left: 15px; background: rgba(0,0,0,0.7);
        color: #fff; font-size: 9px; font-weight: 900; padding: 5px 12px; border-radius: 30px;
        display: flex; align-items: center; gap: 8px; backdrop-filter: blur(4px);
    }
    .pulse-dot { width: 6px; height: 6px; background: #ef4444; border-radius: 50%; box-shadow: 0 0 10px #ef4444; animation: pulse-red 1.5s infinite; }
    @keyframes pulse-red { 0% { opacity: 0.4; } 50% { opacity: 1; } 100% { opacity: 0.4; } }

    .btn-dark-focus { background: #000; color: #fff; border: none; transition: 0.2s; }
    .btn-dark-focus:hover { background: #334155; transform: scale(1.02); }

    /* Global Animations */
    .animate-slide-up { opacity: 0; animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }

    @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .floating-hero-img { animation: float-neo 6s ease-in-out infinite; }
    @keyframes float-neo { 0%, 100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-15px) scale(1.02); } }

    .shadow-2xl { box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.1); }

    /* Swiper Premium Customization */
    .swiper-button-disabled {
        opacity: 0.3 !important;
        cursor: not-allowed !important;
    }
    .swiper-prev-watching:hover, .swiper-next-watching:hover,
    .swiper-prev-shorts:hover, .swiper-next-shorts:hover,
    .swiper-prev-recommended:hover, .swiper-next-recommended:hover {
        background-color: var(--focus-primary) !important;
        color: #fff !important;
        border-color: var(--focus-primary) !important;
    }
    .swiper-slide {
        height: auto;
    }
    .card-focus, .short-card-focus, .course-card-focus {
        height: 100%;
    }

    /* Trending Categories Neo */
    .cat-card-neo {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .cat-card-neo:hover {
        transform: translateY(-8px) scale(1.02);
        border-color: var(--focus-primary) !important;
        box-shadow: 0 15px 30px rgba(79, 70, 229, 0.1);
    }
    .cat-card-neo:hover .cat-icon-box {
        transform: rotate(10deg);
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tracks Swiper
        new Swiper('.tracksSwiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            navigation: {
                nextEl: '.swiper-next-tracks',
                prevEl: '.swiper-prev-tracks',
            },
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 24 },
                1024: { slidesPerView: 5, spaceBetween: 24 },
            },
        });

        // Continue Watching Swiper
        new Swiper('.continueWatchingSwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-next-watching',
                prevEl: '.swiper-prev-watching',
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 24 },
            },
        });

        // Shorts Swiper
        new Swiper('.shortsSwiper', {
            slidesPerView: 2,
            spaceBetween: 15,
            navigation: {
                nextEl: '.swiper-next-shorts',
                prevEl: '.swiper-prev-shorts',
            },
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 6, spaceBetween: 20 },
            },
        });

        // Quotes Swiper
        new Swiper('.quotesSwiper', {
            slidesPerView: 1,
            spaceBetween: 50,
            loop: true,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.quotes-pagination',
                clickable: true,
            },
        });

        // Recommended Swiper
        new Swiper('.recommendedSwiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-next-recommended',
                prevEl: '.swiper-prev-recommended',
            },
        });

        // Courses Swiper
        new Swiper('.coursesSwiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            navigation: {
                nextEl: '.swiper-next-courses',
                prevEl: '.swiper-prev-courses',
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 24 },
                1024: { slidesPerView: 4, spaceBetween: 24 },
            },
        });
    });
</script>
@endsection