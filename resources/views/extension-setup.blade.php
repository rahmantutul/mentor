@extends('layouts.user')

@section('title', 'AI Extension Setup — CRTVAI')

@section('styles')
<style>
    .setup-hero {
        background: linear-gradient(135deg, #020617 0%, #1e1b4b 100%);
        border-radius: 32px;
        padding: 80px 60px;
        color: #fff;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .setup-hero::after {
        content: '';
        position: absolute;
        top: -20%;
        right: -10%;
        width: 50%;
        height: 140%;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
        transform: rotate(-15deg);
    }
    .step-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 40px;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .step-card:hover {
        transform: translateY(-8px);
        border-color: #6366f1;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    }
    .step-number {
        width: 44px;
        height: 44px;
        background: #f1f5f9;
        color: #475569;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
        margin-bottom: 24px;
    }
    .step-card:hover .step-number {
        background: #6366f1;
        color: #fff;
    }
    .feature-badge {
        padding: 6px 14px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .install-btn-large {
        background: #fff;
        color: #020617;
        border: none;
        padding: 18px 40px;
        border-radius: 18px;
        font-weight: 800;
        font-size: 16px;
        transition: 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }
    .install-btn-large:hover {
        background: #f8fafc;
        transform: scale(1.02);
    }
    .connection-pill {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        padding: 12px 20px;
        border-radius: 14px;
        font-family: monospace;
        font-weight: 700;
        color: #475569;
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-width: 280px;
    }
    .copy-btn {
        background: #fff;
        border: 1px solid #e2e8f0;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 800;
        cursor: pointer;
        transition: 0.2s;
    }
    .copy-btn:hover { background: #f1f5f9; }

    .btn-generate {
        background: #6366f1;
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 800;
        transition: 0.2s;
    }
    .btn-generate:hover {
        background: #4f46e5;
        transform: scale(1.02);
    }
    .timer-badge {
        font-size: 11px;
        font-weight: 800;
        color: #ef4444;
        display: none;
    }
    .device-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 20px;
        transition: 0.3s;
    }
    .device-card:hover {
        border-color: #6366f1;
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="setup-hero animate-slide-up">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="d-flex gap-2 mb-4">
                    <span class="feature-badge">v1.2.0 Stable</span>
                    <span class="feature-badge">Official Extension</span>
                </div>
                <h1 class="display-4 fw-800 mb-3" style="letter-spacing: -0.05em;">Take AI Intelligence Anywhere with Our Chrome Extension</h1>
                <p class="fs-5 opacity-75 mb-5 fw-500" style="max-width: 600px; line-height: 1.6;">
                    Analyze web content, extract insights, and connect your workflow directly to the CRTVAI ecosystem. Our custom-built extension brings the power of your AI Mentor to every tab you visit.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#" class="install-btn-large">
                        <i class="bi bi-download"></i> Download Extension Bundle
                    </a>
                    <a href="https://chrome.google.com/webstore" target="_blank" class="btn btn-outline-light border-2 rounded-4 px-4 fw-800 d-flex align-items-center" style="border-radius: 18px !important;">
                        View on Web Store
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <div class="position-relative d-inline-block">
                    <div class="bg-primary rounded-circle blur-3xl opacity-20 position-absolute w-100 h-100 top-0 start-0"></div>
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop" class="img-fluid rounded-5 shadow-2xl position-relative z-1" style="max-height: 400px; border: 8px solid rgba(255,255,255,0.1);">
                </div>
            </div>
        </div>
    </div>

    <!-- Installation Steps -->
    <div class="mb-5 animate-slide-up delay-1">
        <div class="text-center mb-5">
            <h2 class="fw-800 text-dark" style="letter-spacing: -0.03em;">Setup Instructions</h2>
            <p class="text-muted">Follow these 3 simple steps to activate your workspace connection.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h5 class="fw-800 text-dark mb-3">Download & Extract</h5>
                    <p class="text-muted small fw-600 mb-0">Click the download button above to get the extension ZIP. Extract the contents to a folder on your computer where it won't be moved.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">2</div>
                    <h5 class="fw-800 text-dark mb-3">Load Extension</h5>
                    <p class="text-muted small fw-600 mb-0">Open Chrome and navigate to <code>chrome://extensions</code>. Enable <strong>Developer Mode</strong> at the top right, then click <strong>"Load unpacked"</strong> and select your extracted folder.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card">
                    <div class="step-number">3</div>
                    <h5 class="fw-800 text-dark mb-3">Connect Profile</h5>
                    <p class="text-muted small fw-600 mb-0">Open the extension from your toolbar. Use the Unique Connection Key provided below to link your account and start syncing data.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Connection Key Section -->
    <div class="card border-0 shadow-sm rounded-5 p-5 animate-slide-up delay-2 mb-5" style="background: #f8fafc; border: 1px solid #e2e8f0 !important;">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="fw-800 text-dark mb-2">Your Unique Connection Key</h4>
                <p class="text-muted small fw-600 mb-4 mb-lg-0">This key is required to authenticate your extension with your CRTVAI account. Keep it secure.</p>
            </div>
            <div class="col-lg-6 text-lg-end">
                <div id="code-display-area" style="display: none;">
                    <div class="d-flex flex-column align-items-end gap-2">
                        <div class="connection-pill">
                            <span id="key-text">CRTVAI-XXXXXX</span>
                            <button class="copy-btn" onclick="copyKey()">COPY KEY</button>
                        </div>
                        <span class="timer-badge" id="expiry-timer">Expires in 10:00</span>
                    </div>
                </div>
                <div id="generate-area">
                    <button class="btn-generate" id="btn-generate-code" onclick="generateCode()">
                        <i class="bi bi-shield-lock-fill me-2"></i> Generate Connection Key
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Linked Devices -->
    <div class="animate-slide-up delay-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-800 text-dark mb-0">Linked Extension Devices</h4>
            <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-800" style="font-size: 12px;">{{ $devices->count() }} ACTIVE</span>
        </div>

        @if($devices->isEmpty())
            <div class="text-center py-5 bg-light rounded-5 border border-dashed">
                <i class="bi bi-laptop text-muted" style="font-size: 40px;"></i>
                <p class="text-muted fw-700 mt-3">No extension devices linked yet.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($devices as $device)
                <div class="col-md-6 col-xl-4">
                    <div class="device-card d-flex justify-content-between align-items-center">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="bg-primary-subtle text-primary rounded-3 p-3">
                                <i class="bi bi-browser-chrome fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-800 text-dark mb-1">{{ $device->device_name ?? 'Unknown Device' }}</h6>
                                <p class="text-muted mb-0" style="font-size: 11px; font-weight: 600;">
                                    Last active: {{ $device->last_active_at ? $device->last_active_at->diffForHumans() : 'Never' }}
                                </p>
                            </div>
                        </div>
                        <button class="btn btn-outline-danger btn-sm border-0 rounded-3" onclick="revokeDevice('{{ $device->device_id }}', '{{ $device->id }}')" title="Revoke Access">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="text-center mt-5 pt-4">
        <p class="text-muted small fw-700">Need help? <a href="#" class="text-primary text-decoration-none">Contact Support</a> or <a href="#" class="text-primary text-decoration-none">Read the Full Documentation</a></p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let timerInterval;

    function generateCode() {
        const btn = document.getElementById('btn-generate-code');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Generating...';

        fetch('{{ route("extension.verify-code") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            const result = data.data;
            document.getElementById('key-text').innerText = result.verification_code;
            document.getElementById('generate-area').style.display = 'none';
            document.getElementById('code-display-area').style.display = 'block';
            document.getElementById('expiry-timer').style.display = 'block';
            
            startTimer(result.expires_in_seconds);
            showToast('Verification code generated successfully', 'success');
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to generate code', 'danger');
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-shield-lock-fill me-2"></i> Generate Connection Key';
        });
    }

    function startTimer(duration) {
        let timer = duration, minutes, seconds;
        clearInterval(timerInterval);
        
        timerInterval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            document.getElementById('expiry-timer').textContent = "Expires in " + minutes + ":" + seconds;

            if (--timer < 0) {
                clearInterval(timerInterval);
                document.getElementById('code-display-area').style.display = 'none';
                document.getElementById('generate-area').style.display = 'block';
                showToast('Verification code expired', 'warning');
            }
        }, 1000);
    }

    function revokeDevice(deviceId, linkId) {
        if (!confirm('Are you sure you want to revoke this device? The extension will stop working immediately.')) return;

        fetch('/extension/device/' + linkId + '/revoke', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.data.unlinked) {
                showToast('Device revoked successfully', 'success');
                setTimeout(() => window.location.reload(), 1000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Failed to revoke device', 'danger');
        });
    }

    function copyKey() {
        const key = document.getElementById('key-text').innerText;
        
        // Fallback for non-HTTPS or older browsers
        if (!navigator.clipboard) {
            const textArea = document.createElement("textarea");
            textArea.value = key;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                handleCopySuccess();
            } catch (err) {
                console.error('Fallback copy failed', err);
            }
            document.body.removeChild(textArea);
            return;
        }

        navigator.clipboard.writeText(key).then(() => {
            handleCopySuccess();
        }).catch(err => {
            console.error('Async copy failed', err);
        });
    }

    function handleCopySuccess() {
        const btn = document.querySelector('.copy-btn');
        btn.innerText = 'COPIED!';
        btn.classList.add('bg-success', 'text-white', 'border-success');
        
        showToast('Connection key copied to clipboard', 'success');

        setTimeout(() => {
            btn.innerText = 'COPY KEY';
            btn.classList.remove('bg-success', 'text-white', 'border-success');
        }, 2000);
    }

    function showToast(message, type = 'success') {
        // Assuming there's a global toast function or simple alert
        console.log(message);
        // You can implement a nice bootstrap toast here if needed
    }
</script>
@endsection
