@extends(Auth::user()->is_admin ? 'layouts.admin' : 'layouts.user')

@section('content')
<!-- Header Section -->
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="page-title mb-1">System Logs</h2>
        <p class="text-muted mb-0">Detailed chronological log of every tracked interaction across the platform.</p>
    </div>
    <div class="col-md-6 text-md-end d-flex justify-content-md-end gap-2">
        <div class="bg-white px-3 py-2 rounded-3 border shadow-sm small fw-bold">
            <span class="text-primary">{{ number_format($filtered_count) }}</span> Total Entries
        </div>
        <a href="{{ route('activity.history') }}" class="btn btn-light border rounded-3 px-3 fw-bold">
            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
        </a>
    </div>
</div>

<!-- Advanced Filter Bar -->
<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body p-4">
        <form action="{{ route('activity.history') }}" method="GET" class="row g-3 align-items-end">
            @if(Auth::user()->is_admin)
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1">User Context</label>
                <select name="user_id" class="form-select border-light-subtle rounded-3">
                    <option value="">All Users</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-3">
                <label class="form-label small fw-bold text-muted mb-1">Mother Domain</label>
                <select name="domain" class="form-select border-light-subtle rounded-3">
                    <option value="">All Domains</option>
                    @foreach($domains as $d)
                        <option value="{{ $d }}" {{ request('domain') == $d ? 'selected' : '' }}>{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-muted mb-1">Search Keywords</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 rounded-end-3" placeholder="Title, URL, or Search query...">
                </div>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-primary rounded-3 fw-bold py-2 shadow-sm">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>
</div>

<!-- History Table -->
<div class="card border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4 border-0 text-muted small fw-bold py-3">USER & SOURCE</th>
                    <th class="border-0 text-muted small fw-bold py-3">ENGAGEMENT TARGET</th>
                    <th class="border-0 text-muted small fw-bold py-3">PERFORMANCE</th>
                    <th class="border-0 text-muted small fw-bold py-3 text-end pe-4">RECORDED AT</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                @if(Auth::user()->is_admin)
                                    <div class="avatar-box me-3 bg-soft-primary text-primary fw-bold rounded-circle shadow-sm" style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;">
                                        {{ strtoupper(substr($item->user->name, 0, 1)) }}
                                    </div>
                                @else
                                    <div class="bg-light p-2 rounded-3 me-3 border">
                                        <img src="https://www.google.com/s2/favicons?domain={{ $item->domain }}&sz=64" width="24" height="24" onerror="this.src='https://www.google.com/s2/favicons?domain=google.com&sz=64'">
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold small text-dark">{{ Auth::user()->is_admin ? $item->user->name : $item->domain }}</div>
                                    <div class="text-muted" style="font-size: 10px;">{{ $item->domain }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small fw-bold text-primary text-truncate mb-1" style="max-width: 400px;">
                                <a href="{{ $item->url }}" target="_blank" class="text-decoration-none">{{ $item->title ?: 'No Page Title Recorded' }}</a>
                            </div>
                            <div class="d-flex gap-1 flex-wrap">
                                @if($item->search_query)
                                    <span class="badge bg-soft-warning text-warning border-0 px-2 py-1" style="font-size: 9px;">
                                        <i class="bi bi-search me-1"></i> QUERY: {{ $item->search_query }}
                                    </span>
                                @endif
                                @php $clicks = is_array($item->clicks) ? $item->clicks : json_decode($item->clicks, true) ?? []; @endphp
                                @if(count($clicks) > 0)
                                    <span class="badge bg-soft-secondary text-secondary border-0 px-2 py-1" style="font-size: 9px;">
                                        <i class="bi bi-cursor-fill me-1"></i> {{ count($clicks) }} USER INTERACTIONS
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1" style="width: 150px;">
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted" style="font-size: 10px;">Engagement</span>
                                    <span class="fw-bold text-success" style="font-size: 10px;">{{ round($item->active_time_ms/1000) }}s active</span>
                                </div>
                                <div class="progress" style="height: 4px; border-radius: 10px;">
                                    <div class="progress-bar bg-gradient-primary" style="width: {{ $item->scroll_depth }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="fw-bold text-dark small">{{ \Carbon\Carbon::createFromTimestampMs($item->timestamp)->format('H:i:s') }}</div>
                            <div class="text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::createFromTimestampMs($item->timestamp)->format('M d, Y') }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="mb-3 text-muted opacity-50"><i class="bi bi-search fs-1"></i></div>
                            <h5 class="text-muted">No activities found in history</h5>
                            <p class="small text-muted mb-0">Try adjusting your filters or checking back later.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($history->hasPages())
        <div class="p-4 border-top bg-light-subtle d-flex justify-content-center">
            {{ $history->links() }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .bg-soft-primary { background: rgba(124, 111, 255, 0.1); }
    .bg-soft-success { background: rgba(52, 211, 153, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-secondary { background: rgba(148, 163, 184, 0.1); }
    .bg-gradient-primary { background: var(--accent-gradient); }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; border: none; padding: 15px 20px; color: #64748b; }
</style>
@endsection
