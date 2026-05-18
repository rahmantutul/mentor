<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TrackWave - Learn AI for Your Work</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-black: #000000;
            --primary-white: #ffffff;
            --secondary-gray: #f8fafc;
            --text-muted: #64748b;
            --border-color: #f1f5f9;
            --accent-indigo: #4338ca;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--primary-black);
            background-color: var(--primary-white);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .fw-800 { font-weight: 800; }
        .fw-700 { font-weight: 700; }
        .fw-600 { font-weight: 600; }

        /* Navbar */
        .navbar {
            padding: 24px 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
        }
        .navbar-brand { letter-spacing: -0.02em; }
        .nav-link {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary-black) !important;
            opacity: 0.5;
            transition: all 0.2s;
            padding: 0 18px !important;
        }
        .nav-link:hover { opacity: 1; }
        
        .btn-login {
            font-size: 13px;
            font-weight: 800;
            color: var(--primary-black);
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }
        .btn-signup {
            font-size: 13px;
            font-weight: 800;
            background: var(--primary-black);
            color: var(--primary-white);
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 10px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-signup:hover { transform: translateY(-1px); box-shadow: 0 6px 15px rgba(0,0,0,0.15); }

        /* Hero Section */
        .hero-section { padding: 140px 0 100px; }
        .tagline {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 24px;
            opacity: 0.6;
        }
        .hero-title {
            font-size: 72px;
            font-weight: 800;
            line-height: 1.05;
            letter-spacing: -0.05em;
            margin-bottom: 32px;
        }
        .hero-title span { color: #000; opacity: 1; }
        .hero-subtitle {
            font-size: 20px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 48px;
            max-width: 540px;
            font-weight: 500;
        }
        
        .hero-mockup-wrapper {
            position: relative;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 32px;
            padding: 12px;
            box-shadow: 0 50px 100px -20px rgba(0,0,0,0.12);
        }
        .hero-mockup-wrapper img {
            border-radius: 20px;
            width: 100%;
        }

        /* Feature Icons (Below Hero) */
        .hero-features-row { margin-top: 64px; }
        .hero-feature-item {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .hero-feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .hero-feature-text { font-size: 13px; font-weight: 700; line-height: 1.3; }
        .hero-feature-text span { font-weight: 500; opacity: 0.5; }

        /* Section Styling */
        .section-padding { padding: 120px 0; }
        .section-tag {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            opacity: 0.4;
            margin-bottom: 24px;
        }
        .section-title {
            font-size: 44px;
            font-weight: 800;
            letter-spacing: -0.04em;
            margin-bottom: 80px;
            line-height: 1.2;
        }

        /* Problem Cards */
        .problem-card {
            padding: 0 15px;
        }
        .problem-icon {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 32px;
            color: #000;
        }
        .problem-card h5 { font-weight: 800; font-size: 19px; margin-bottom: 16px; letter-spacing: -0.02em; }
        .problem-card p { font-size: 15px; color: var(--text-muted); line-height: 1.6; font-weight: 500; }

        /* Solution Section */
        .solution-section {
            background: #f8fafc;
            padding: 120px 0;
            border-radius: 80px;
            margin: 60px 0;
        }
        .solution-node { text-align: center; position: relative; padding: 0 10px; }
        .node-icon {
            width: 88px;
            height: 88px;
            border-radius: 28px;
            background: #fff;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 24px;
            box-shadow: 0 15px 35px -10px rgba(0,0,0,0.05);
        }
        .node-arrow {
            position: absolute;
            top: 44px;
            right: -25%;
            font-size: 28px;
            opacity: 0.15;
            color: #000;
        }

        /* Feature Rows */
        .feature-list-item {
            display: flex;
            gap: 24px;
            margin-bottom: 40px;
        }
        .feature-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            background: #fff;
        }
        .feature-list-text h6 { font-weight: 800; font-size: 16px; margin-bottom: 8px; }
        .feature-list-text p { font-size: 14px; color: var(--text-muted); line-height: 1.5; font-weight: 500; }

        /* Features Grid */
        .grid-feature-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 40px;
            height: 100%;
            transition: all 0.3s ease;
            text-align: left;
        }
        .grid-feature-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08); border-color: #000; }

        /* CTA Box */
        .cta-container { padding: 120px 0; }
        .cta-box {
            background: #000;
            color: #fff;
            padding: 100px 40px;
            border-radius: 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-rocket {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 40px;
        }

        /* Footer */
        .footer { padding: 100px 0 60px; border-top: 1px solid #f1f5f9; }
        .footer-logo { font-size: 24px; font-weight: 800; margin-bottom: 32px; }
        .footer-desc { font-size: 14px; color: var(--text-muted); line-height: 1.6; max-width: 280px; margin-bottom: 32px; font-weight: 500; }
        .footer-heading { font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 32px; }
        .footer-links a { display: block; font-size: 14px; color: var(--text-muted); text-decoration: none; margin-bottom: 16px; font-weight: 600; transition: 0.2s; }
        .footer-links a:hover { color: #000; }

        .social-links a { font-size: 20px; color: var(--text-muted); transition: 0.2s; }
        .social-links a:hover { color: #000; }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-title { font-size: 56px; }
            .node-arrow { display: none; }
            .section-padding { padding: 80px 0; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand fw-800" href="#">LOGO</a>
            <div class="collapse navbar-collapse d-none d-lg-block">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#">How it Works</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">For Teams</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link d-flex align-items-center" href="#">Resources <i class="bi bi-chevron-down ms-2" style="font-size: 10px;"></i></a></li>
                </ul>
            </div>
            <div class="ms-auto d-flex gap-3 align-items-center">
                <a href="{{ route('login') }}" class="btn-login">Log in</a>
                <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="tagline">AI-PERSONALIZED LEARNING</div>
                    <h1 class="hero-title">Learn AI for Your Work. Not Random Content.</h1>
                    <p class="hero-subtitle">Personalized learning that understands your role, your goals, and how you work.</p>
                    <div class="d-flex flex-wrap gap-3 mb-5">
                        <a href="{{ route('register') }}" class="btn-signup py-3 px-5 fs-6" style="border-radius: 12px;">Start Learning Free</a>
                        <a href="#" class="btn-login py-3 px-5 fs-6 d-flex align-items-center gap-2" style="border-radius: 12px;">
                            <i class="bi bi-play-circle-fill fs-5"></i> Watch Demo
                        </a>
                    </div>
                    <div class="d-flex flex-wrap gap-4 pt-2">
                        <div class="hero-feature-item">
                            <div class="hero-feature-icon"><i class="bi bi-person"></i></div>
                            <div class="hero-feature-text">Personalized<br><span>content for your role</span></div>
                        </div>
                        <div class="hero-feature-item">
                            <div class="hero-feature-icon"><i class="bi bi-check-circle"></i></div>
                            <div class="hero-feature-text">Real-world<br><span>use cases</span></div>
                        </div>
                        <div class="hero-feature-item">
                            <div class="hero-feature-icon"><i class="bi bi-graph-up"></i></div>
                            <div class="hero-feature-text">AI mentor<br><span>guidance</span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-mockup-wrapper">
                        <img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?auto=format&fit=crop&w=1400" alt="AI Dashboard Interface">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- The Problem -->
    <section class="section-padding">
        <div class="container text-center">
            <div class="section-tag">THE PROBLEM</div>
            <h2 class="section-title">Why learning AI today is inefficient</h2>
            <div class="row g-5">
                <div class="col-md-3">
                    <div class="problem-card">
                        <div class="problem-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                        <h5>Too much scattered content</h5>
                        <p>You waste hours searching but still don't find what's relevant.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="problem-card">
                        <div class="problem-icon"><i class="bi bi-person-x"></i></div>
                        <h5>Not relevant to your job</h5>
                        <p>Most content isn't tailored to your role or real work problems.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="problem-card">
                        <div class="problem-icon"><i class="bi bi-diagram-3"></i></div>
                        <h5>No clear learning path</h5>
                        <p>No structure. No direction. Hard to know what to learn next.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="problem-card">
                        <div class="problem-icon"><i class="bi bi-question-circle"></i></div>
                        <h5>No real application</h5>
                        <p>You learn but don't know how to actually apply it in real situations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- The Solution -->
    <section class="container">
        <div class="solution-section text-center">
            <div class="section-tag">THE SOLUTION</div>
            <h2 class="section-title">A system that learns how you work</h2>
            <div class="row g-4 mt-5">
                <div class="col-md-3">
                    <div class="solution-node">
                        <div class="node-icon"><i class="bi bi-puzzle"></i></div>
                        <h6 class="fw-800 small mb-2">AI understands your work</h6>
                        <p class="text-muted small px-3">Our extension (optional) understands the tools you use and the tasks you do.</p>
                        <div class="node-arrow"><i class="bi bi-arrow-right"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="solution-node">
                        <div class="node-icon"><i class="bi bi-play-btn"></i></div>
                        <h6 class="fw-800 small mb-2">Recommends relevant content</h6>
                        <p class="text-muted small px-3">You get personalized videos, shorts, and learning paths that match your needs.</p>
                        <div class="node-arrow"><i class="bi bi-arrow-right"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="solution-node">
                        <div class="node-icon"><i class="bi bi-chat-text"></i></div>
                        <h6 class="fw-800 small mb-2">You interact and apply</h6>
                        <p class="text-muted small px-3">Ask questions, save, like, dislike, and request custom content.</p>
                        <div class="node-arrow"><i class="bi bi-arrow-right"></i></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="solution-node">
                        <div class="node-icon"><i class="bi bi-cpu"></i></div>
                        <h6 class="fw-800 small mb-2">AI improves over time</h6>
                        <p class="text-muted small px-3">The more you learn and work, the better the recommendations become.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Action Section -->
    <section class="section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-tag">SEE IT IN ACTION</div>
                <h2 class="section-title">Built for modern learners</h2>
            </div>
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="hero-mockup-wrapper">
                        <img src="https://images.unsplash.com/photo-1551288049-bbbda536339a?auto=format&fit=crop&w=1400" alt="Data Analytics Interface">
                    </div>
                </div>
                <div class="col-lg-5 ps-lg-5">
                    <div class="feature-list-item">
                        <div class="feature-icon-box shadow-sm"><i class="bi bi-card-list"></i></div>
                        <div class="feature-list-text">
                            <h6>Personalized feed</h6>
                            <p>AI-curated videos and shorts based on your role, goals, and activity.</p>
                        </div>
                    </div>
                    <div class="feature-list-item">
                        <div class="feature-icon-box shadow-sm"><i class="bi bi-stars"></i></div>
                        <div class="feature-list-text">
                            <h6>AI mentor</h6>
                            <p>Ask questions about any video or topic and get instant answers.</p>
                        </div>
                    </div>
                    <div class="feature-list-item">
                        <div class="feature-icon-box shadow-sm"><i class="bi bi-bookmark-plus"></i></div>
                        <div class="feature-list-text">
                            <h6>Create your own lists</h6>
                            <p>Save videos and build custom lists for your projects and goals.</p>
                        </div>
                    </div>
                    <div class="feature-list-item">
                        <div class="feature-icon-box shadow-sm"><i class="bi bi-magic"></i></div>
                        <div class="feature-list-text">
                            <h6>Request custom content</h6>
                            <p>Can't find what you need? Request a topic and we'll create it.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Powerful Features Grid -->
    <section class="section-padding">
        <div class="container text-center">
            <div class="section-tag">POWERFUL FEATURES</div>
            <h2 class="section-title">Everything you need to learn and apply AI</h2>
            <div class="row g-4">
                @php
                    $feats = [
                        ['n' => 'Personalized Feed', 'd' => 'Content tailored to your role, goals, and progress.', 'i' => 'bi bi-person'],
                        ['n' => 'AI Mentor', 'd' => 'Get answers, explanations, and guidance in context.', 'i' => 'bi bi-chat-left-dots'],
                        ['n' => 'Learning Paths', 'd' => 'Follow structured paths to build real skills.', 'i' => 'bi bi-signpost-2'],
                        ['n' => 'Save & Organize', 'd' => 'Save videos and create custom lists.', 'i' => 'bi bi-bookmark'],
                        ['n' => 'Ask on Any Video', 'd' => 'Ask questions about videos and get answers.', 'i' => 'bi bi-patch-question'],
                        ['n' => 'Custom Content', 'd' => 'Request custom videos on any topic you need.', 'i' => 'bi bi-magic'],
                    ];
                @endphp
                @foreach($feats as $f)
                <div class="col-md-4">
                    <div class="grid-feature-card">
                        <div class="feature-icon-box mb-4 shadow-sm" style="background: #f8fafc; border-radius: 12px;"><i class="{{ $f['i'] }}"></i></div>
                        <h6>{{ $f['n'] }}</h6>
                        <p class="text-muted small mb-0">{{ $f['d'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Footer -->
    <section class="container cta-container">
        <div class="cta-box">
            <div class="cta-rocket shadow-sm">
                <i class="bi bi-rocket-takeoff text-white"></i>
            </div>
            <h2 class="fw-800 mb-5" style="font-size: 40px; letter-spacing: -0.04em;">Start learning AI that<br>actually applies to your work</h2>
            <div class="d-inline-block text-center">
                <a href="{{ route('register') }}" class="btn btn-white bg-white text-dark py-3 px-5 fw-800 rounded-3 mb-3 shadow-lg">Create Free Account</a>
                <div class="text-white opacity-40 small fw-600">No credit card required</div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <div class="footer-logo">LOGO</div>
                    <p class="footer-desc">The AI learning platform that understands your work and helps you grow faster.</p>
                    <div class="d-flex gap-3 social-links">
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer-heading">Platform</div>
                    <div class="footer-links">
                        <a href="#">How it Works</a>
                        <a href="#">Features</a>
                        <a href="#">Pricing</a>
                        <a href="#">Roadmap</a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer-heading">Resources</div>
                    <div class="footer-links">
                        <a href="#">Blog</a>
                        <a href="#">Help Center</a>
                        <a href="#">Guides</a>
                        <a href="#">Community</a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer-heading">Company</div>
                    <div class="footer-links">
                        <a href="#">About Us</a>
                        <a href="#">Careers</a>
                        <a href="#">Contact</a>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer-heading">Legal</div>
                    <div class="footer-links">
                        <a href="#">Terms of Service</a>
                        <a href="#">Privacy Policy</a>
                        <a href="#">Cookie Policy</a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5 pt-5 border-top border-light-subtle">
                <p class="text-muted small fw-700">&copy; 2024 YourBrand. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
