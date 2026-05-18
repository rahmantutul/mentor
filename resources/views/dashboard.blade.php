@extends('layouts.app')

@section('content')
<!-- Header Section -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold text-gradient mb-1">Activity Overview</h2>
        <p class="text-muted small mb-0">High-level summary of network activity and user engagement</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('activity.history') }}" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-clock-history me-2"></i> View Full History
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm stat-hover">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-soft-primary text-primary">
                    <i class="bi bi-activity fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 lh-1">{{ number_format($total_records) }}</h4>
                    <p class="text-muted small mb-0 mt-1">Total Activities</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm stat-hover">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-soft-success text-success">
                    <i class="bi bi-people fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 lh-1">{{ $total_users }}</h4>
                    <p class="text-muted small mb-0 mt-1">Monitored Users</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm stat-hover">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-soft-warning text-warning">
                    <i class="bi bi-globe2 fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 lh-1">{{ count($domains) }}</h4>
                    <p class="text-muted small mb-0 mt-1">Active Domains</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 border-0 shadow-sm stat-hover">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon bg-soft-info text-info">
                    <i class="bi bi-shield-check fs-5"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0 lh-1">{{ Auth::user()->is_admin ? 'Admin' : 'Extension' }}</h4>
                    <p class="text-muted small mb-0 mt-1">Role Control</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Activity Snapshot -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">Recent Activity Pulse</h5>
                <span class="badge bg-soft-info text-info">Live Stream</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Source</th>
                            <th>Page Title</th>
                            <th class="text-end pe-4">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_activity as $item)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if(Auth::user()->is_admin)
                                            <div class="avatar-sm bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 32px; height: 32px; font-size: 11px;">
                                                {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                            </div>
                                        @else
                                            <img src="https://www.google.com/s2/favicons?domain={{ $item->domain }}&sz=32" class="me-2 rounded-1">
                                        @endif
                                        <span class="small fw-bold">{{ Auth::user()->is_admin ? $item->user->name : $item->domain }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="small text-truncate" style="max-width: 300px;">
                                        {{ $item->title ?: $item->url }}
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="text-muted small">{{ \Carbon\Carbon::createFromTimestampMs($item->timestamp)->diffForHumans() }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-5 text-muted small">No recent activity detected.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3 text-center">
                <a href="{{ route('activity.history') }}" class="btn btn-link btn-sm text-decoration-none fw-bold">View all history <i class="bi bi-chevron-right small"></i></a>
            </div>
        </div>
    </div>

    <!-- Top Domains Summary -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-4 px-4">
                <h5 class="fw-bold mb-0 text-dark">Top Monitored Sites</h5>
            </div>
            <div class="card-body px-4 pt-0">
                <div class="d-flex flex-column gap-3">
                    @foreach($domains->take(5) as $domain)
                        <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-light-subtle border">
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://www.google.com/s2/favicons?domain={{ $domain }}&sz=32" width="24" height="24" class="rounded-circle shadow-sm">
                                <span class="small fw-bold text-dark">{{ $domain }}</span>
                            </div>
                            <i class="bi bi-graph-up text-success small"></i>
                        </div>
                    @endforeach
                    @if($domains->count() > 5)
                        <p class="text-center text-muted small mt-2">and {{ $domains->count() - 5 }} others...</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .stat-hover { transition: all 0.2s; border-radius: 15px; }
    .stat-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .stat-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .bg-soft-primary { background: rgba(124, 111, 255, 0.1); }
    .bg-soft-success { background: rgba(52, 211, 153, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-info { background: rgba(13, 202, 240, 0.1); }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border: none; padding: 15px 20px; color: #64748b; }
</style>
@endsection
