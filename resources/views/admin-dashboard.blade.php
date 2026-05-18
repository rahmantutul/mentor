@extends('layouts.admin')

@section('styles')
<style>
    /* ── Pagination ───────────────────────────────────────────── */
    .pagination { gap: 4px; margin: 0; }
    .page-item .page-link {
        width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;
        border-radius: 10px !important; border: 1.5px solid #e5e7eb;
        color: #374151; font-weight: 700; font-size: 13px; background: #fff;
        transition: all 0.2s; padding: 0; line-height: 1; text-decoration: none;
    }
    .page-item .page-link:hover { background: #f9fafb; border-color: #000; color: #000; box-shadow: none; }
    .page-item.active .page-link { background: #000 !important; border-color: #000 !important; color: #fff !important; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .page-item.disabled .page-link { background: #f9fafb; border-color: #f1f3f5; color: #d1d5db; pointer-events: none; }
    .page-item:first-child .page-link, .page-item:last-child .page-link { width: auto; padding: 0 14px; font-size: 12px; }

    /* Hide 'Showing X to Y' text */
    nav .flex-1.sm\:hidden, 
    nav .hidden.sm\:flex-1 { 
        display: flex !important; 
        justify-content: center !important; 
    }
    nav .hidden.sm\:flex-1 > div:first-child {
        display: none !important;
    }
    nav .relative.z-0.inline-flex.shadow-sm.rounded-md {
        box-shadow: none !important;
    }

    .stat-icon-box { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 14px; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .fw-800 { font-weight: 800; }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="page-title mb-1">Admin Command Center</h1>
            <p class="text-muted small mb-0">Real-time platform analytics and student engagement oversight.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.contents.index') }}" class="btn btn-outline-dark rounded-3 fw-bold px-4">
                <i class="bi bi-play-btn me-2"></i> Content Library
            </a>
            <button class="btn btn-dark rounded-3 fw-bold px-4">
                <i class="bi bi-download me-2"></i> Export Data
            </button>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="stat-icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-eye-fill fs-4"></i>
                        </div>
                        <span class="text-success fw-bold small"><i class="bi bi-arrow-up"></i> Live</span>
                    </div>
                    <h3 class="fw-800 mb-1">{{ number_format($totalViews) }}</h3>
                    <p class="text-muted mb-0 small fw-bold opacity-75 text-uppercase">Total Impressions</p>
                </div>
                <div style="height: 4px; background: #6366f1;"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="stat-icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-check2-circle fs-4"></i>
                        </div>
                        <span class="text-success fw-bold small"><i class="bi bi-arrow-up"></i> Stable</span>
                    </div>
                    <h3 class="fw-800 mb-1">{{ round($avgCompletion) }}%</h3>
                    <p class="text-muted mb-0 small fw-bold opacity-75 text-uppercase">Avg. Completion</p>
                </div>
                <div style="height: 4px; background: #10b981;"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="stat-icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                        <span class="text-muted small fw-bold">Active</span>
                    </div>
                    <h3 class="fw-800 mb-1">{{ \App\Models\User::formatSeconds($totalWatchTime) }}</h3>
                    <p class="text-muted mb-0 small fw-bold opacity-75 text-uppercase">Study Duration</p>
                </div>
                <div style="height: 4px; background: #f59e0b;"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="stat-icon-box bg-info bg-opacity-10 text-info">
                            <i class="bi bi-people-fill fs-4"></i>
                        </div>
                        <span class="text-success fw-bold small"><i class="bi bi-arrow-up"></i> Realtime</span>
                    </div>
                    <h3 class="fw-800 mb-1">{{ number_format($uniqueViewers) }}</h3>
                    <p class="text-muted mb-0 small fw-bold opacity-75 text-uppercase">Active Students</p>
                </div>
                <div style="height: 4px; background: #0ea5e9;"></div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-800 mb-0">Platform Engagement Trends</h6>
                    <select class="form-select form-select-sm w-auto border-0 bg-light rounded-3 fw-bold small">
                        <option>Last 30 Days</option>
                        <option>Last 7 Days</option>
                    </select>
                </div>
                <div style="height: 300px;">
                    <canvas id="engagementChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 h-100">
                <h6 class="fw-800 mb-4">Content Category Interest</h6>
                <div style="height: 250px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- User Engagement Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header bg-white border-0 p-4 pb-0">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-800 mb-0">Student-Wise Engagement Analysis</h5>
                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted small"></i>
                    <input type="text" id="userSearch" class="form-control ps-5 border-0 bg-light rounded-4 fw-medium small" style="width: 250px;" placeholder="Search students...">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="userAnalyticsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-uppercase small fw-800 text-muted">Student Profile</th>
                            <th class="py-3 border-0 text-uppercase small fw-800 text-muted">Primary Goal</th>
                            <th class="py-3 border-0 text-uppercase small fw-800 text-muted">Top Topics</th>
                            <th class="py-3 border-0 text-uppercase small fw-800 text-muted text-center">Engagement</th>
                            <th class="pe-4 py-3 border-0 text-uppercase small fw-800 text-muted text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr class="user-row" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                            <td class="ps-4 py-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-dark text-white fw-800 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 13px;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-800 text-dark mb-0 small">{{ $user->name }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark fw-bold small text-truncate" style="max-width: 150px;">{{ $user->primary_goal ?? 'Not set' }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ $user->experience_level ?? 'Student' }}</div>
                            </td>
                            <td>
                                @php
                                    $topCats = $user->videoProgress->map(fn($p) => $p->content->category ?? 'General')->countBy()->sortDesc()->take(2);
                                @endphp
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($topCats as $cat => $count)
                                        <span class="badge bg-primary bg-opacity-10 text-primary small rounded-pill px-2 py-1" style="font-size: 9px;">{{ $cat }}</span>
                                    @endforeach
                                </div>
                            </td>
                            @php
                                $totalVideos = $user->videoProgress->count();
                                $avgComp = $totalVideos > 0 ? $user->videoProgress->avg('completion_percent') : 0;
                            @endphp
                            <td class="text-center">
                                <div class="d-inline-flex flex-column align-items-center">
                                    <div class="fw-800 text-dark mb-1" style="font-size: 11px;">{{ round($avgComp) }}%</div>
                                    <div class="progress" style="width: 60px; height: 4px; border-radius: 10px;">
                                        <div class="progress-bar bg-success" style="width: {{ $avgComp }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-white border rounded-3 fw-800 px-3 py-2 small" type="button" data-bs-toggle="collapse" data-bs-target="#userDetails{{ $index }}">
                                    Deep Dive <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="collapse-row">
                            <td colspan="5" class="p-0 border-0">
                                <div class="collapse" id="userDetails{{ $index }}">
                                    <div class="p-5 bg-light bg-opacity-50 border-bottom">
                                        <div class="row g-5">
                                            <div class="col-lg-4 border-end">
                                                <h6 class="fw-800 mb-4 text-uppercase letter-spacing-1" style="font-size: 10px;">Personalized Track</h6>
                                                <div class="mb-4">
                                                    <p class="text-muted small mb-1 fw-bold">INTEREST TAGS</p>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($user->interests ?? [] as $int)
                                                            <span class="badge bg-white text-dark border rounded-3 px-2 py-1 small fw-bold">{{ $int }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-muted small mb-1 fw-bold">PLATFORM TOOLS</p>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($user->tools ?? [] as $tool)
                                                            <span class="badge bg-dark text-white rounded-3 px-2 py-1 small">{{ $tool }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <h6 class="fw-800 mb-4 text-uppercase letter-spacing-1" style="font-size: 10px;">Recent Activity & Progress</h6>
                                                <div class="row g-3">
                                                    @forelse($user->videoProgress->sortByDesc('last_watched_at')->take(4) as $history)
                                                    <div class="col-md-6">
                                                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                                                            <div class="fw-bold text-dark text-truncate mb-2 small">{{ $history->content->title ?? 'Deleted' }}</div>
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="text-muted" style="font-size: 10px;">{{ round($history->completion_percent) }}% Progress</span>
                                                                <span class="badge {{ $history->completed ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill" style="font-size: 8px;">{{ $history->completed ? 'Done' : 'Active' }}</span>
                                                            </div>
                                                            <div class="progress" style="height: 3px; border-radius: 10px;">
                                                                <div class="progress-bar bg-primary" style="width: {{ $history->completion_percent }}%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div class="col-12 text-center py-4">No activity tracked yet.</div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 bg-white border-top d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search Functionality
        const searchInput = document.getElementById('userSearch');
        const userRows = document.querySelectorAll('.user-row');
        const collapseRows = document.querySelectorAll('.collapse-row');

        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            userRows.forEach((row, index) => {
                const searchText = row.getAttribute('data-search');
                if (searchText.indexOf(filter) > -1) {
                    row.style.display = "";
                    collapseRows[index].style.display = "";
                } else {
                    row.style.display = "none";
                    collapseRows[index].style.display = "none";
                }
            });
        });

        // Engagement Chart
        const ctxEngagement = document.getElementById('engagementChart').getContext('2d');
        const grad = ctxEngagement.createLinearGradient(0, 0, 0, 400);
        grad.addColorStop(0, 'rgba(99, 102, 241, 0.1)');
        grad.addColorStop(1, 'rgba(255, 255, 255, 0)');

        new Chart(ctxEngagement, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Platform Usage',
                    data: [45, 59, 80, 81, 56, 95, 120],
                    borderColor: '#000',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: grad,
                    pointBackgroundColor: '#000',
                    pointBorderWidth: 0,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f1f3f5' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Category Chart
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categoryStats->pluck('category')) !!},
                datasets: [{
                    data: {!! json_encode($categoryStats->pluck('count')) !!},
                    backgroundColor: ['#000', '#4f46e5', '#10b981', '#f59e0b', '#0ea5e9', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 20, font: { family: 'Plus Jakarta Sans', weight: '700', size: 10 } }
                    }
                }
            }
        });
    });
</script>
@endsection
