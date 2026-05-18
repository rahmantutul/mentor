@extends('layouts.admin')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-title mb-1">User Profile</h2>
                <p class="text-muted">Viewing profile details for {{ $user->name }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-light rounded-3 fw-bold">
                <i class="bi bi-arrow-left me-2"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content Area -->
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div class="d-flex align-items-center gap-4">
                    <div class="avatar-large" style="width: 64px; height: 64px; font-size: 22px; margin: 0; background: #f1f5f9; color: #6366f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strrchr($user->name, " "), 1, 1)) ?: '' }}
                    </div>
                    <div>
                        <h1 class="fw-800 h3 mb-1" style="color: #000;">{{ $user->name }}</h1>
                        <p class="small fw-800 mb-0" style="color: #000; opacity: 0.6;">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Accordion Container -->
            <div class="accordion-custom">
                
                <!-- Section: Profile -->
                <div class="accordion-item shadow-sm mb-3 rounded-4 overflow-hidden border border-light-subtle">
                    <div class="accordion-header active p-4 d-flex justify-content-between align-items-center cursor-pointer bg-white" onclick="toggleAccordion(this)">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="bi bi-person text-dark"></i></div>
                            <span class="fw-800 h6 mb-0" style="color: #000;">Profile</span>
                        </div>
                        <i class="bi bi-chevron-down chevron-icon transition-transform"></i>
                    </div>
                    <div class="accordion-body p-4 border-top border-light-subtle bg-white" style="display: block;">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="small fw-800 text-muted text-uppercase mb-1" style="font-size: 10px;">Full Name</label>
                                <p class="fw-800 mb-0" style="color: #000;">{{ $user->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-800 text-muted text-uppercase mb-1" style="font-size: 10px;">Email Address</label>
                                <p class="fw-800 mb-0" style="color: #000;">{{ $user->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-800 text-muted text-uppercase mb-1" style="font-size: 10px;">Member Since</label>
                                <p class="fw-800 mb-0" style="color: #000;">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-800 text-muted text-uppercase mb-1" style="font-size: 10px;">Account Type</label>
                                <div class="d-flex align-items-center gap-3">
                                    <p class="fw-800 mb-0" style="color: #000;">{{ $user->account_type ?? 'Free Plan' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Learning Preferences -->
                <div class="accordion-item shadow-sm mb-3 rounded-4 overflow-hidden border border-light-subtle">
                    <div class="accordion-header p-4 d-flex justify-content-between align-items-center cursor-pointer bg-white" onclick="toggleAccordion(this)">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="bi bi-book text-dark"></i></div>
                            <span class="fw-800 h6 mb-0" style="color: #000;">Learning Preferences</span>
                        </div>
                        <i class="bi bi-chevron-down chevron-icon transition-transform"></i>
                    </div>
                    <div class="accordion-body p-4 border-top border-light-subtle bg-white" style="display: none;">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="small fw-800 text-dark mb-1" style="font-size: 11px;">Primary Goal</label>
                                <p class="fw-800 mb-0" style="color: #000;">{{ $user->primary_goal ?: 'Not set' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-800 text-dark mb-1" style="font-size: 11px;">Experience Level</label>
                                <p class="fw-800 mb-0" style="color: #000;">{{ $user->experience_level ?: 'Not set' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Work & Tools -->
                <div class="accordion-item shadow-sm mb-3 rounded-4 overflow-hidden border border-light-subtle">
                    <div class="accordion-header p-4 d-flex justify-content-between align-items-center cursor-pointer bg-white" onclick="toggleAccordion(this)">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="bi bi-briefcase text-dark"></i></div>
                            <span class="fw-800 h6 mb-0" style="color: #000;">Work & Tools</span>
                        </div>
                        <i class="bi bi-chevron-down chevron-icon transition-transform"></i>
                    </div>
                    <div class="accordion-body p-4 border-top border-light-subtle bg-white" style="display: none;">
                        <div class="d-flex flex-wrap gap-3">
                            @if($user->tools)
                                @foreach($user->tools as $tool)
                                    <div class="tool-badge-pill">
                                        @php
                                            $icon = 'https://www.google.com/s2/favicons?domain=' . strtolower($tool) . '.com&sz=32';
                                            if (strtolower($tool) == 'gmail') $icon = 'https://www.gstatic.com/images/branding/product/2x/gmail_48dp.png';
                                            if (strtolower($tool) == 'notion') $icon = 'https://upload.wikimedia.org/wikipedia/commons/4/45/Notion_app_logo.png';
                                            if (strtolower($tool) == 'slack') $icon = 'https://upload.wikimedia.org/wikipedia/commons/b/b9/Slack_Technologies_Logo.svg';
                                            if (strtolower($tool) == 'youtube') $icon = 'https://upload.wikimedia.org/wikipedia/commons/e/ef/Youtube_logo.png';
                                        @endphp
                                        <img src="{{ $icon }}" alt="{{ $tool }}" width="18">
                                        <span>{{ $tool }}</span>
                                        <i class="bi bi-check-circle-fill text-success ms-2"></i>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted small">No tools added yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Section: Interests -->
                <div class="accordion-item shadow-sm mb-3 rounded-4 overflow-hidden border border-light-subtle">
                    <div class="accordion-header p-4 d-flex justify-content-between align-items-center cursor-pointer bg-white" onclick="toggleAccordion(this)">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="bi bi-hash text-dark"></i></div>
                            <span class="fw-800 h6 mb-0" style="color: #000;">Interests</span>
                        </div>
                        <i class="bi bi-chevron-down chevron-icon transition-transform"></i>
                    </div>
                    <div class="accordion-body p-4 border-top border-light-subtle bg-white" style="display: none;">
                        <div class="d-flex flex-wrap gap-2">
                            @if($user->interests)
                                @foreach($user->interests as $interest)
                                    <span class="topic-tag">{{ $interest }}</span>
                                @endforeach
                            @else
                                <p class="text-muted small">No interests added yet.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Section: Video Engagement -->
                <div class="accordion-item shadow-sm mb-3 rounded-4 overflow-hidden border border-light-subtle">
                    <div class="accordion-header p-4 d-flex justify-content-between align-items-center cursor-pointer bg-white" onclick="toggleAccordion(this)">
                        <div class="d-flex align-items-center gap-3">
                            <div class="header-icon bg-light rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="bi bi-play-btn-fill text-dark"></i></div>
                            <span class="fw-800 h6 mb-0" style="color: #000;">Video Engagement</span>
                        </div>
                        <i class="bi bi-chevron-down chevron-icon transition-transform"></i>
                    </div>
                    <div class="accordion-body p-4 border-top border-light-subtle bg-white" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 small fw-800 text-muted text-uppercase" style="font-size: 10px;">Video Title</th>
                                        <th class="border-0 small fw-800 text-muted text-uppercase text-center" style="font-size: 10px;">Time Spent</th>
                                        <th class="border-0 small fw-800 text-muted text-uppercase text-center" style="font-size: 10px;">Completion</th>
                                        <th class="border-0 small fw-800 text-muted text-uppercase text-end" style="font-size: 10px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $fakeHistory = [
                                            ['title' => 'Mastering AI Prompts', 'time' => '18m 45s', 'rate' => 100, 'status' => 'Completed'],
                                            ['title' => 'Introduction to Neural Networks', 'time' => '12m 10s', 'rate' => 45, 'status' => 'In Progress'],
                                            ['title' => 'Stable Diffusion Tutorial', 'time' => '25m 30s', 'rate' => 100, 'status' => 'Completed'],
                                            ['title' => 'The Future of Generative AI', 'time' => '05m 15s', 'rate' => 15, 'status' => 'In Progress'],
                                        ];
                                    @endphp
                                    @foreach($fakeHistory as $item)
                                    <tr>
                                        <td class="py-3">
                                            <div class="fw-bold" style="color: #000;">{{ $item['title'] }}</div>
                                        </td>
                                        <td class="text-center py-3">
                                            <span class="badge bg-light text-dark fw-800">{{ $item['time'] }}</span>
                                        </td>
                                        <td class="text-center py-3">
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <div class="progress w-100" style="height: 6px; max-width: 100px;">
                                                    <div class="progress-bar bg-primary" style="width: {{ $item['rate'] }}%"></div>
                                                </div>
                                                <span class="fw-800 small">{{ $item['rate'] }}%</span>
                                            </div>
                                        </td>
                                        <td class="text-end py-3">
                                            <span class="badge {{ $item['status'] == 'Completed' ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar-large {
        width: 80px;
        height: 80px;
        background: #f1f3f5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 800;
        color: #000;
    }

    .topic-tag {
        padding: 6px 14px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        color: #000;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tool-badge-pill {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        color: #000;
    }

    /* Accordion Styles */
    .accordion-header {
        transition: all 0.2s ease;
    }
    
    .accordion-header:hover {
        background-color: #f8fafc !important;
    }
    
    .accordion-header.active .chevron-icon {
        transform: rotate(180deg);
    }
    
    .cursor-pointer {
        cursor: pointer;
    }
    
    .transition-transform {
        transition: transform 0.3s ease;
    }

    .fw-800 { font-weight: 800; }
</style>
@endsection

@section('scripts')
<script>
function toggleAccordion(element) {
    const body = element.nextElementSibling;
    const isVisible = body.style.display === 'block';
    
    // Toggle active class on header
    element.classList.toggle('active');
    
    // Toggle visibility
    body.style.display = isVisible ? 'none' : 'block';
}
</script>
@endsection
