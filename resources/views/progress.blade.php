@extends('layouts.user')

@section('content')
<div class="dashboard-content" style="color: #000; padding-top: 20px;">
    <div class="container-fluid px-0">
        
        <!-- Header Section -->
        <div class="d-flex align-items-center justify-content-between mb-5">
            <div>
                <h2 class="fw-800 mb-1" style="letter-spacing: -0.03em; font-size: 28px;">My Progress</h2>
                <p class="text-dark opacity-50 fw-600 mb-0" style="font-size: 14px;">Track your learning journey and see how you're growing.</p>
            </div>
            <div class="d-flex gap-3 align-items-center">
                <div class="date-picker-mock bg-white border border-light-subtle rounded-3 px-3 py-2 d-flex align-items-center gap-3 shadow-sm">
                    <span class="fw-700 text-dark opacity-75" style="font-size: 13px;">May 7 - May 13, 2024</span>
                    <i class="bi bi-calendar3 text-dark opacity-50"></i>
                </div>
                <button class="btn btn-white border border-light-subtle rounded-3 px-3 py-2 fw-800 shadow-sm d-flex align-items-center gap-2" style="font-size: 13px;">
                    <i class="bi bi-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Top Stats Overview -->
        <div class="row g-3 mb-5">
            <div class="col-md-3">
                <div class="card stat-card border border-light-subtle rounded-4 p-4 bg-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="text-dark opacity-50 fw-800" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Total Learning Time</div>
                        <div class="stat-icon-circle bg-light text-indigo"><i class="bi bi-clock"></i></div>
                    </div>
                    <div class="h3 fw-800 mb-2">18h 42m</div>
                    <div class="text-success fw-800" style="font-size: 12px;"><i class="bi bi-arrow-up"></i> 12% vs last week</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border border-light-subtle rounded-4 p-4 bg-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="text-dark opacity-50 fw-800" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Videos Watched</div>
                        <div class="stat-icon-circle bg-light text-primary"><i class="bi bi-play-circle"></i></div>
                    </div>
                    <div class="h3 fw-800 mb-2">42</div>
                    <div class="text-success fw-800" style="font-size: 12px;"><i class="bi bi-arrow-up"></i> 16% vs last week</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border border-light-subtle rounded-4 p-4 bg-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="text-dark opacity-50 fw-800" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Current Streak</div>
                        <div class="stat-icon-circle bg-light text-warning"><i class="bi bi-fire"></i></div>
                    </div>
                    <div class="h3 fw-800 mb-2">7 days</div>
                    <div class="text-dark opacity-40 fw-700" style="font-size: 12px;">Best: 14 days</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border border-light-subtle rounded-4 p-4 bg-white shadow-sm">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="text-dark opacity-50 fw-800" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">AI Interactions</div>
                        <div class="stat-icon-circle bg-light text-info"><i class="bi bi-stars"></i></div>
                    </div>
                    <div class="h3 fw-800 mb-2">24</div>
                    <div class="text-success fw-800" style="font-size: 12px;"><i class="bi bi-arrow-up"></i> 33% vs last week</div>
                </div>
            </div>
        </div>

        <!-- Charts Section (Simplified) -->
        <div class="row g-4 mb-5">
            <div class="col-lg-8">
                <div class="card border border-light-subtle rounded-4 p-4 bg-white shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <h6 class="fw-800 mb-0">Learning Time Over Time</h6>
                            <div class="text-dark opacity-40 fw-700 mt-1" style="font-size: 11px;">Track your daily engagement intensity</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-white btn-sm border border-light-subtle rounded-3 px-3 fw-800" style="font-size: 11px;">Daily</button>
                            <button class="btn btn-dark btn-sm rounded-3 px-3 fw-800" style="font-size: 11px;">Weekly</button>
                        </div>
                    </div>
                    
                    <div class="chart-container-premium position-relative" style="height: 280px;">
                        <!-- Grid Lines -->
                        <div class="chart-grid d-flex flex-column justify-content-between h-100 w-100 position-absolute top-0 start-0 pe-4">
                            <div class="grid-line"><span>20h</span></div>
                            <div class="grid-line"><span>15h</span></div>
                            <div class="grid-line"><span>10h</span></div>
                            <div class="grid-line"><span>5h</span></div>
                            <div class="grid-line border-0"><span>0h</span></div>
                        </div>

                        <!-- Bars -->
                        <div class="d-flex align-items-end justify-content-between h-100 px-4 position-relative" style="z-index: 2; padding-bottom: 30px;">
                            @php 
                                $data = [
                                    ['day' => 'Mon', 'val' => 45, 'today' => false],
                                    ['day' => 'Tue', 'val' => 70, 'today' => false],
                                    ['day' => 'Wed', 'val' => 55, 'today' => false],
                                    ['day' => 'Thu', 'val' => 90, 'today' => true],
                                    ['day' => 'Fri', 'val' => 65, 'today' => false],
                                    ['day' => 'Sat', 'val' => 40, 'today' => false],
                                    ['day' => 'Sun', 'val' => 30, 'today' => false],
                                ]; 
                            @endphp
                            @foreach($data as $item)
                            <div class="chart-bar-wrapper flex-grow-1">
                                <div class="chart-bar-premium {{ $item['today'] ? 'active' : '' }}" style="height: {{ max(10, $item['val']) }}%;">
                                    @if($item['today'])
                                    <div class="chart-tooltip-mock">
                                        <div class="fw-800">4h 12m</div>
                                        <div class="opacity-50" style="font-size: 8px;">TODAY</div>
                                    </div>
                                    @endif
                                </div>
                                <span class="chart-label-premium">{{ $item['day'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border border-light-subtle rounded-4 p-4 bg-white shadow-sm h-100">
                    <h6 class="fw-800 mb-5">Learning by Category</h6>
                    <div class="d-flex flex-column gap-4">
                        @php
                            $categories = [
                                ['name' => 'AI Automation', 'time' => '6h 12m', 'percent' => 33, 'color' => '#7c3aed'],
                                ['name' => 'Productivity', 'time' => '4h 30m', 'percent' => 24, 'color' => '#10b981'],
                                ['name' => 'Marketing', 'time' => '3h 25m', 'percent' => 18, 'color' => '#f59e0b'],
                                ['name' => 'Coding', 'time' => '2h 15m', 'percent' => 12, 'color' => '#3b82f6'],
                            ];
                        @endphp
                        @foreach($categories as $cat)
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle" style="width: 8px; height: 8px; background: {{ $cat['color'] }};"></div>
                                    <span class="fw-800 text-dark small">{{ $cat['name'] }}</span>
                                </div>
                                <span class="text-dark opacity-50 fw-700 small">{{ $cat['time'] }} ({{ $cat['percent'] }}%)</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 6px; background: #f1f3f5;">
                                <div class="progress-bar rounded-pill" style="width: {{ $cat['percent'] }}%; background: {{ $cat['color'] }};"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity & Heatmap Row -->
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="card border border-light-subtle rounded-4 p-4 bg-white shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-800 mb-0">Recent Activity</h6>
                        <a href="#" class="text-dark opacity-50 fw-800 small text-decoration-none">View all</a>
                    </div>
                    <div class="list-group list-group-flush">
                        @php
                            $activities = [
                                ['title' => 'Build an AI Agent', 'type' => 'Tutorial', 'time' => 'Today', 'icon' => 'bi bi-play-fill'],
                                ['title' => 'Automate Gmail with AI', 'type' => 'Shorts', 'time' => 'Yesterday', 'icon' => 'bi bi-lightning-fill'],
                                ['title' => 'Content Creation Workflow', 'type' => 'Tutorial', 'time' => '2 days ago', 'icon' => 'bi bi-play-fill'],
                                ['title' => '5 Best AI Tools', 'type' => 'Shorts', 'time' => '3 days ago', 'icon' => 'bi bi-lightning-fill'],
                            ];
                        @endphp
                        @foreach($activities as $act)
                        <div class="list-group-item border-0 px-0 mb-2 rounded-3 d-flex align-items-center justify-content-between py-2 transition-hover">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                    <i class="{{ $act['icon'] }}"></i>
                                </div>
                                <div>
                                    <div class="fw-800 text-dark" style="font-size: 13px;">{{ $act['title'] }}</div>
                                    <div class="text-dark opacity-50 fw-700" style="font-size: 11px;">{{ $act['type'] }} • {{ $act['time'] }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border border-light-subtle rounded-4 p-4 bg-white shadow-sm h-100 text-center">
                    <h6 class="fw-800 mb-4 text-start">Learning Activity</h6>
                    <div class="heatmap-container d-flex flex-wrap gap-2 justify-content-center pt-3">
                        @for($i=0; $i<42; $i++)
                        @php $intensity = rand(0, 3); @endphp
                        <div class="heatmap-box" data-intensity="{{ $intensity }}"></div>
                        @endfor
                    </div>
                    <div class="d-flex justify-content-center gap-3 mt-4 text-dark opacity-40 fw-800" style="font-size: 10px;">
                        <span>Less</span>
                        <div class="d-flex gap-1">
                            <div class="heatmap-box" data-intensity="0"></div>
                            <div class="heatmap-box" data-intensity="1"></div>
                            <div class="heatmap-box" data-intensity="2"></div>
                            <div class="heatmap-box" data-intensity="3"></div>
                        </div>
                        <span>More</span>
                    </div>
                    <p class="mt-4 text-dark opacity-50 small fw-700">You are most active between 7 PM - 10 PM</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border border-light-subtle rounded-4 p-4 bg-white shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-800 mb-0">Skills You're Building</h6>
                        <a href="#" class="text-dark opacity-50 fw-800 small text-decoration-none">View all</a>
                    </div>
                    <div class="d-flex flex-column gap-4">
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-800 text-dark small">Prompt Engineering</span>
                                <span class="text-dark opacity-50 fw-700 small">Advanced • 85%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 4px; background: #f1f3f5;">
                                <div class="progress-bar bg-dark rounded-pill" style="width: 85%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-800 text-dark small">AI Automation</span>
                                <span class="text-dark opacity-50 fw-700 small">Intermediate • 60%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 4px; background: #f1f3f5;">
                                <div class="progress-bar bg-dark rounded-pill" style="width: 60%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-800 text-dark small">Data Analysis</span>
                                <span class="text-dark opacity-50 fw-700 small">Beginner • 42%</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 4px; background: #f1f3f5;">
                                <div class="progress-bar bg-dark rounded-pill" style="width: 42%;"></div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-dark w-100 mt-auto py-2 fw-800 small rounded-3 shadow-sm">Explore More Skills</button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('styles')
<style>
    .stat-icon-circle {
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
    }
    
    .text-indigo { color: #7c3aed; }
    
    .heatmap-box {
        width: 22px; height: 22px; border-radius: 4px;
        background: #f1f3f5;
        transition: all 0.2s;
    }
    
    .heatmap-box[data-intensity="1"] { background: #dbeafe; }
    .heatmap-box[data-intensity="2"] { background: #60a5fa; }
    .heatmap-box[data-intensity="3"] { background: #1d4ed8; }
    
    /* Premium Chart Styles */
    .grid-line {
        border-top: 1px dashed #f1f3f5;
        height: 1px;
        width: 100%;
        position: relative;
    }
    .grid-line span {
        position: absolute;
        right: -30px;
        top: -10px;
        font-size: 10px;
        font-weight: 800;
        color: #000;
        opacity: 0.3;
    }

    .chart-bar-wrapper {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: center;
        position: relative;
    }

    .chart-bar-premium {
        width: 14px;
        background: #e5e7eb;
        border-radius: 20px;
        position: relative;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .chart-bar-premium.active {
        background: #000;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .chart-bar-premium:hover {
        background: #000;
        transform: scaleX(1.5);
    }

    .chart-label-premium {
        position: absolute;
        bottom: -25px;
        font-size: 10px;
        font-weight: 800;
        color: #000;
        opacity: 0.4;
    }

    .chart-tooltip-mock {
        position: absolute;
        top: -50px;
        left: 50%;
        transform: translateX(-50%);
        background: #000;
        color: #fff;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        white-space: nowrap;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .chart-tooltip-mock::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #000;
    }

    .stat-card { transition: all 0.3s ease; cursor: pointer; }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px -5px rgba(0,0,0,0.1) !important; }
    
    .list-group-item:hover { background-color: #f8fafc !important; }
</style>
@endsection
