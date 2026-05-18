@extends('layouts.admin')

@section('styles')
<style>
    /* ── Pagination ───────────────────────────────────────────── */
    .pagination {
        gap: 4px;
        margin: 0;
    }
    .page-item .page-link {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px !important;
        border: 1.5px solid #e5e7eb;
        color: #374151;
        font-weight: 700;
        font-size: 13px;
        background: #fff;
        transition: all 0.2s;
        padding: 0;
        line-height: 1;
        text-decoration: none;
    }
    .page-item .page-link:hover {
        background: #f9fafb;
        border-color: #000;
        color: #000;
        box-shadow: none;
    }
    .page-item.active .page-link {
        background: #000 !important;
        border-color: #000 !important;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .page-item.disabled .page-link {
        background: #f9fafb;
        border-color: #f1f3f5;
        color: #d1d5db;
        pointer-events: none;
    }
    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        width: auto;
        padding: 0 14px;
        font-size: 12px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Content Analytics</h1>
            <p class="text-muted">Track how your content is performing across the platform.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary rounded-3 border-2 fw-bold px-4">
                <i class="bi bi-download me-2"></i> Export Report
            </button>
            <button class="btn btn-primary rounded-3 fw-bold px-4">
                <i class="bi bi-calendar3 me-2"></i> Last 30 Days
            </button>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-4">
                            <i class="bi bi-eye-fill text-primary fs-4"></i>
                        </div>
                        <span class="text-success fw-bold small"><i class="bi bi-arrow-up"></i> Live</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($totalViews) }}</h3>
                    <p class="text-muted mb-0 small fw-semibold text-uppercase">Total Video Views</p>
                </div>
                <div style="height: 4px; background: linear-gradient(90deg, #6366f1, #818cf8);"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-4">
                            <i class="bi bi-check2-circle text-success fs-4"></i>
                        </div>
                        <span class="text-success fw-bold small"><i class="bi bi-arrow-up"></i> 100% accurate</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ round($avgCompletion) }}%</h3>
                    <p class="text-muted mb-0 small fw-semibold text-uppercase">Avg. Completion Rate</p>
                </div>
                <div style="height: 4px; background: linear-gradient(90deg, #10b981, #34d399);"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-4">
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        </div>
                        <span class="text-muted small fw-bold">Active</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ \App\Models\User::formatSeconds($totalWatchTime) }}</h3>
                    <p class="text-muted mb-0 small fw-semibold text-uppercase">Total Watch Time</p>
                </div>
                <div style="height: 4px; background: linear-gradient(90deg, #f59e0b, #fbbf24);"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="bg-info bg-opacity-10 p-3 rounded-4">
                            <i class="bi bi-people-fill text-info fs-4"></i>
                        </div>
                        <span class="text-success fw-bold small"><i class="bi bi-arrow-up"></i> Realtime</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ number_format($uniqueViewers) }}</h3>
                    <p class="text-muted mb-0 small fw-semibold text-uppercase">Unique Viewers</p>
                </div>
                <div style="height: 4px; background: linear-gradient(90deg, #0ea5e9, #38bdf8);"></div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-transparent border-0 p-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Engagement Trends</h5>
                        <select class="form-select form-select-sm w-auto border-0 bg-light rounded-3 fw-semibold">
                            <option>Views</option>
                            <option>Completion Rate</option>
                        </select>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="engagementChart" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                <div class="card-header bg-transparent border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">Category Performance</h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="categoryChart" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- User Engagement Table -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-header bg-transparent border-0 p-4 pb-0">
            <div class="d-flex flex-column flex-md-row justify-content-between align-md-center gap-3">
                <h5 class="fw-bold mb-0">User-Wise Engagement Analytics</h5>
                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="userSearch" class="form-control ps-5 border-0 bg-light rounded-4 fw-medium" style="width: 300px;" placeholder="Search user name or email...">
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="userAnalyticsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-uppercase small fw-bold text-muted">User Profile</th>
                            <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Top Interests</th>
                            <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Learning Categories</th>
                            <th class="py-3 border-0 text-uppercase small fw-bold text-muted text-center">Engagement</th>
                            <th class="py-3 border-0 text-uppercase small fw-bold text-muted text-center">Watch Time</th>
                            <th class="pe-4 py-3 border-0 text-uppercase small fw-bold text-muted text-end">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr class="user-row" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                            <td class="ps-4 py-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar bg-dark text-white fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; font-size: 14px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-800 text-dark mb-0" style="font-size: 14px;">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(array_slice($user->interests ?? [], 0, 2) as $interest)
                                        <span class="badge bg-light text-dark border small rounded-pill fw-bold" style="font-size: 9px; padding: 3px 8px;">{{ $interest }}</span>
                                    @endforeach
                                    @if(count($user->interests ?? []) > 2)
                                        <span class="text-muted small">+{{ count($user->interests) - 2 }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @php
                                    $categories = $user->videoProgress->map(fn($p) => $p->content->category ?? 'General')->countBy()->sortDesc()->take(2);
                                @endphp
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($categories as $cat => $count)
                                        <span class="badge bg-primary bg-opacity-10 text-primary small rounded-pill fw-bold" style="font-size: 9px; padding: 3px 8px;">{{ $cat }}</span>
                                    @endforeach
                                </div>
                            </td>
                            @php
                                $totalVideos = $user->videoProgress->count();
                                $completedVideos = $user->videoProgress->where('completed', true)->count();
                                $totalSeconds = $user->videoProgress->sum('watched_seconds');
                                $avgCompletion = $totalVideos > 0 ? $user->videoProgress->avg('completion_percent') : 0;
                            @endphp
                            <td class="text-center">
                                <div class="d-inline-flex flex-column align-items-center">
                                    <div class="fw-bold text-dark small mb-1">{{ round($avgCompletion) }}% Done</div>
                                    <div class="progress" style="width: 60px; height: 4px; border-radius: 10px;">
                                        <div class="progress-bar bg-success" style="width: {{ $avgCompletion }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="fw-800 text-dark mb-0" style="font-size: 13px;">{{ \App\Models\User::formatSeconds($totalSeconds) }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ $totalVideos }} videos</div>
                            </td>
                            <td class="pe-4 text-end">
                                <button class="btn btn-sm btn-white border rounded-3 fw-800 px-3 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#userDetails{{ $index }}">
                                    Deep Analytics <i class="bi bi-chevron-down ms-1"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="collapse-row">
                            <td colspan="6" class="p-0 border-0">
                                <div class="collapse" id="userDetails{{ $index }}">
                                    <div class="p-5 bg-light bg-opacity-50 border-bottom">
                                        <div class="row g-5">
                                            <!-- User Insights -->
                                            <div class="col-lg-4 border-end">
                                                <h6 class="fw-800 mb-4 text-uppercase letter-spacing-1" style="font-size: 11px;">User Insights & Behavior</h6>
                                                <div class="mb-4">
                                                    <p class="text-muted small mb-1 fw-bold">EXPERIENCE LEVEL</p>
                                                    <span class="badge bg-dark rounded-pill px-3">{{ $user->experience_level ?? 'Not set' }}</span>
                                                </div>
                                                <div class="mb-4">
                                                    <p class="text-muted small mb-1 fw-bold">PRIMARY GOAL</p>
                                                    <p class="fw-800 text-dark small mb-0">{{ $user->primary_goal ?? 'Not defined' }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-muted small mb-1 fw-bold">TOOLS UTILIZED</p>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($user->tools ?? [] as $tool)
                                                            <span class="badge bg-white text-dark border rounded-3 fw-bold small">{{ $tool }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Learning Distribution -->
                                            <div class="col-lg-8">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <h6 class="fw-800 mb-0 text-uppercase letter-spacing-1" style="font-size: 11px;">Course-Wise Deep Analytics</h6>
                                                    <span class="text-muted small">Total: {{ $totalVideos }} items tracked</span>
                                                </div>
                                                <div class="row g-3">
                                                    @forelse($user->videoProgress->sortByDesc('last_watched_at')->take(6) as $history)
                                                    <div class="col-md-6">
                                                        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                                <div class="fw-800 text-dark text-truncate me-2" style="font-size: 13px;" title="{{ $history->content->title ?? 'Deleted' }}">
                                                                    {{ $history->content->title ?? 'Deleted' }}
                                                                </div>
                                                                <span class="badge {{ $history->completed ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill" style="font-size: 9px;">
                                                                    {{ $history->completed ? 'Done' : 'Active' }}
                                                                </span>
                                                            </div>
                                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                                <div class="text-muted fw-bold" style="font-size: 10px;">
                                                                    <i class="bi bi-clock me-1"></i> {{ \App\Models\User::formatSeconds($history->watched_seconds) }} / {{ \App\Models\User::formatSeconds($history->content->duration_seconds ?? 0) }}
                                                                </div>
                                                                <div class="fw-800 text-primary" style="font-size: 11px;">{{ round($history->completion_percent) }}%</div>
                                                            </div>
                                                            <div class="progress mt-2" style="height: 4px; border-radius: 10px;">
                                                                <div class="progress-bar bg-primary" style="width: {{ $history->completion_percent }}%"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div class="col-12 text-center py-4">
                                                        <div class="text-muted small">No detailed engagement records available for this period.</div>
                                                    </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links() }}
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
                    // Keep the collapse row but let it stay collapsed or hidden
                    collapseRows[index].style.display = "";
                } else {
                    row.style.display = "none";
                    collapseRows[index].style.display = "none";
                }
            });
        });

        // Engagement Chart
        const ctxEngagement = document.getElementById('engagementChart').getContext('2d');
        new Chart(ctxEngagement, {
            type: 'line',
            data: {
                labels: ['Jan 01', 'Jan 05', 'Jan 10', 'Jan 15', 'Jan 20', 'Jan 25', 'Jan 30'],
                datasets: [{
                    label: 'Platform Usage (Hours)',
                    data: [120, 190, 150, 250, 220, 300, 450],
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#e2e8f0' }
                    },
                    x: {
                        grid: { display: false }
                    }
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
                    backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#0ea5e9', '#ec4899', '#8b5cf6'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { family: 'Plus Jakarta Sans', weight: '600', size: 11 }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
