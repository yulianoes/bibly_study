<!DOCTYPE html>
<html lang="pt-br" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Bible Intelligent Study</title>

    <link rel="canonical" href="https://bibly-efzy.onrender.com/">
    <meta name="robots" content="index, follow">
    <meta name="google-site-verification" content="OjkqE9D8QZHOFPm9kpNSrDKGTLHweqKOXNM7I0IWl2U" />
    <meta name="keywords"
        content="Bíblia, Teologia, IA, Inteligência Artificial, Estudo Bíblico, Exegese, Hermenêutica, Cristianismo">

    <!-- SEO & Social Media (OpenGraph) -->
    <meta name="description"
        content="Explore as profundezas da teologia com Inteligência Artificial. Estudos bíblicos profissionais.">
    <meta property="og:title" content="Bible Intelligent Study - A Nova era do estudo teológico">
    <meta property="og:description"
        content="Use o poder da IA para aprofundar o seu conhecimento bíblico com alta erudição.">
    <meta property="og:image" content="{{ asset('marketing_fb.png') }}">
    <meta property="og:url" content="https://bibly-efzy.onrender.com/">
    <meta property="og:type" content="website">

    <!-- JSON-LD Structured Data for Google -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "SoftwareApplication",
      "name": "Bible Intelligent Study",
      "operatingSystem": "All",
      "applicationCategory": "EducationalApplication",
      "description": "Plataforma de IA para alta erudição teológica e estudos bíblicos profundos.",
      "offers": {
        "@@type": "Offer",
        "price": "0",
        "priceCurrency": "USD"
      },
      "author": {
        "@@type": "Person",
        "name": "Yuliano Silva"
      }
    }
    </script>

    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Crimson+Pro:ital,wght@0,400;0,600;1,400&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <style>
        :root[data-theme="light"] {
            --bg: #f8f9fa;
            --card-bg: #ffffff;
            --text: #1a202c;
            --muted: #718096;
            --primary: #92754d;
            --primary-glow: rgba(146, 117, 77, 0.1);
            --border: #e2e8f0;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        :root[data-theme="dark"] {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text: #f1f5f9;
            --muted: #94a3b8;
            --primary: #d4af37;
            --primary-glow: rgba(212, 175, 55, 0.15);
            --border: #334155;
            --shadow: 0 4px 25px rgba(0, 0, 0, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            transition: 0.3s;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 850px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            min-height: 100vh;
        }

        /* Navbar & Header */
        .nav {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
        }

        .theme-toggle {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            cursor: pointer;
            color: var(--text);
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            box-shadow: var(--shadow);
        }

        .theme-toggle:hover {
            transform: rotate(15deg);
        }

        header {
            text-align: center;
            margin-bottom: 3rem;
        }

        h1 {
            font-size: clamp(2rem, 8vw, 3.5rem);
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), #4a5568);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -2px;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: var(--muted);
            font-size: 1.1rem;
            font-weight: 300;
            letter-spacing: 1px;
        }

        /* Verse Banner */
        .verse-banner {
            background: linear-gradient(135deg, #1e293b, var(--primary));
            color: white;
            padding: 2.5rem;
            border-radius: 24px;
            margin-bottom: 3rem;
            position: relative;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .verse-banner p {
            font-family: 'Crimson Pro', serif;
            font-size: 1.4rem;
            font-style: italic;
            margin-bottom: 1rem;
            line-height: 1.4;
            opacity: 0.95;
        }

        .verse-banner span {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 600;
        }

        /* Search Pill - Glassmorphism */
        .search-pill {
            position: sticky;
            top: 20px;
            z-index: 1000;
            background: rgba(var(--card-bg), 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border);
            border-radius: 100px;
            display: flex;
            align-items: center;
            padding: 0.4rem;
            margin-bottom: 3.5rem;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.1);
            transition: 0.4s;
        }

        .search-pill:focus-within {
            transform: translateY(-2px);
            border-color: var(--primary);
            box-shadow: 0 20px 50px -15px var(--primary-glow);
        }

        .search-pill select {
            background: transparent;
            border: none;
            color: var(--muted);
            font-size: 0.75rem;
            padding: 0 1.5rem;
            outline: none;
            border-right: 1px solid var(--border);
            cursor: pointer;
        }

        .search-pill input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.8rem 1.2rem;
            font-size: 1.1rem;
            color: var(--text);
            outline: none;
        }

        .btn-study {
            background: var(--primary);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-study:hover {
            transform: scale(1.08);
            background: var(--text);
        }

        .btn-voice {
            background: transparent;
            border: none;
            color: var(--muted);
            padding: 0 0.8rem;
            cursor: pointer;
            font-size: 1.3rem;
        }

        .btn-voice.recording {
            color: #ef4444;
            animation: pulse 1.5s infinite;
        }

        /* Sections & Details */
        .daily-section {
            margin-bottom: 3rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .daily-details {
            margin-bottom: 1.5rem;
        }

        .daily-details summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            list-style: none;
            cursor: pointer;
            padding: 1.2rem 1.8rem;
            background: var(--card-bg);
            border-radius: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: 0.3s;
        }

        .daily-details summary:hover {
            border-color: var(--primary);
        }

        .daily-details summary::-webkit-details-marker {
            display: none;
        }

        .daily-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            padding: 1.5rem 0;
            animation: fadeIn 0.5s;
        }

        .daily-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            padding: 1.5rem;
            border-radius: 20px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .daily-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .daily-card i {
            font-size: 1.4rem;
            color: var(--primary);
        }

        .daily-card span {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .daily-card small {
            font-size: 0.75rem;
            color: var(--muted);
            line-height: 1.4;
        }

        /* Result Card */
        #results {
            animation: slideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .study-card {
            background: var(--card-bg);
            border-radius: 32px;
            padding: 3rem;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        #st-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2.5rem;
            letter-spacing: -1px;
            border-left: 5px solid var(--primary);
            padding-left: 1.5rem;
        }

        #st-details {
            font-family: 'Crimson Pro', serif;
            font-size: 1.3rem;
            line-height: 1.7;
            color: var(--text);
            text-align: justify;
        }

        /* Mind Map */
        .mindmap-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.2rem;
            margin: 3rem 0;
            padding: 2rem;
            background: var(--bg);
            border-radius: 24px;
            border: 1px dashed var(--border);
        }

        .node {
            background: var(--card-bg);
            border: 1px solid var(--primary);
            padding: 0.8rem 1.8rem;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: var(--shadow);
        }

        .connector {
            width: 2px;
            height: 24px;
            background: var(--primary);
            opacity: 0.3;
        }

        .tag {
            display: inline-block;
            padding: 0.5rem 1.2rem;
            background: var(--primary-glow);
            color: var(--primary);
            border-radius: 100px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin: 0.3rem;
        }

        .tag:hover {
            background: var(--primary);
            color: white;
        }

        /* Loader */
        .loader {
            display: none;
            text-align: center;
            padding: 4rem 0;
        }

        .pulse {
            width: 80px;
            height: 80px;
            background: var(--primary-glow);
            border-radius: 50%;
            margin: 0 auto 2rem;
            animation: pulse-animation 1.5s infinite;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes pulse-animation {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(0.8);
                opacity: 0.5;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }

            100% {
                opacity: 1;
            }
        }

        /* Centered Loader */
        .loader {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 5rem 0;
            width: 100%;
        }

        .pulse {
            width: 100px;
            height: 100px;
            background: var(--primary-glow);
            border-radius: 50%;
            margin-bottom: 2rem;
            animation: pulse-animation 1.5s infinite;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Premium Buttons */
        .btn-premium {
            padding: 1.2rem 2.5rem;
            border-radius: 100px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            border: 1px solid var(--border);
            background: var(--card-bg);
            color: var(--text);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow);
            border-color: var(--primary);
        }

        .btn-report {
            background: var(--primary);
            color: white;
            border: none;
        }

        .btn-audio {
            background: var(--primary-glow);
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        /* Footer Refinement */
        footer {
            margin-top: 5rem;
            padding: 4rem 0;
            border-top: 1px solid var(--border);
            text-align: center;
        }

        footer p {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--muted);
            margin-bottom: 0.5rem;
        }

        footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        @media (max-width: 600px) {
            .container {
                padding: 1.2rem;
            }

            .study-card {
                padding: 1.8rem;
                border-radius: 32px;
            }

            .search-pill {
                border-radius: 30px;
                padding: 0.5rem;
            }

            .search-pill select {
                display: block;
                padding: 0 0.8rem;
                font-size: 0.65rem;
                width: 80px;
            }

            .verse-banner {
                padding: 1.5rem;
                border-radius: 20px;
            }

            .daily-grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 2rem;
            }

            .btn-premium {
                width: 100%;
                justify-content: center;
            }
        }

        /* Premium Navbar */
        .premium-nav { position:fixed; top:0; left:0; right:0; z-index:2000; background:rgba(var(--card-bg), 0.7); backdrop-filter:blur(15px); border-bottom:1px solid var(--border); padding:0.8rem 2rem; display:flex; justify-content:space-between; align-items:center; box-shadow:0 10px 30px rgba(0,0,0,0.03); }
        .nav-logo { font-weight:800; font-size:1rem; letter-spacing:-1px; color:var(--primary); text-transform:uppercase; }
        .nav-links { display:flex; gap:1.5rem; align-items:center; }
        .nav-link { font-size:0.7rem; text-transform:uppercase; letter-spacing:2px; font-weight:700; color:var(--muted); cursor:pointer; transition:0.3s; text-decoration:none; }
        .nav-link:hover { color:var(--primary); }
        .nav-link.active { color:var(--primary); border-bottom:2px solid var(--primary); padding-bottom:4px; }

        @media (max-width: 600px) {
            .premium-nav { padding:0.8rem 1.2rem; }
            .nav-links { gap:1rem; }
            .nav-link { font-size:0.6rem; letter-spacing:1px; }
            .nav-logo { display:none; }
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
                font-family: 'Crimson Pro', serif;
            }

            .nav,
            .theme-toggle,
            .search-pill,
            .daily-section,
            .btn-zen,
            .btn-premium,
            #loader,
            footer,
            #st-videos-container,
            .section-header,
            #st-suggestions,
            .mindmap-container {
                display: none !important;
            }

            .container {
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
            }

            .study-card {
                box-shadow: none !important;
                border: none !important;
                padding: 1cm !important;
                margin: 0 !important;
                width: 100% !important;
            }

            #st-title {
                font-size: 2.8rem !important;
                text-align: center;
                margin-bottom: 1cm;
                color: black !important;
            }

            #st-details {
                font-size: 12pt !important;
                line-height: 1.7;
                color: black !important;
                min-height: auto !important;
            }

            #print-header {
                display: block !important;
                border-bottom: 1px solid #000;
                padding-bottom: 1cm;
                margin-bottom: 1.5cm;
                text-align: center;
            }

            #st-application-box {
                border: 1px solid #ccc !important;
                background: none !important;
                page-break-inside: avoid;
                padding: 1cm !important;
                margin-top: 2cm !important;
            }

            #st-application-box h4 {
                color: black !important;
            }

            .daily-grid {
                display: none !important;
            }

            /* Hide the grid of verses in print to keep it clean */
        }
    </style>
</head>

<body>
    <nav class="premium-nav">
        <div class="nav-logo">Bible Intelligent</div>
        <div class="nav-links">
            <span class="nav-link" onclick="toggleMenuSection('daily')">Temas</span>
            <span class="nav-link" onclick="toggleMenuSection('history')">Histórico</span>
            <span class="nav-link" onclick="toggleMenuSection('favs')">Favoritos</span>
            <button class="theme-toggle" id="theme-toggle" style="width:35px; height:35px; border-radius:8px;"><i class="bi bi-sun"></i></button>
        </div>
    </nav>

    <div class="container" style="padding-top:6rem;">

        <header>
            <h1>Bible Intelligent Study</h1>
            <p class="subtitle">A Alta Era da Erudição Teológica</p>
        </header>

        <div class="verse-banner">
            <p id="daily-verse-text">{{ $verse['text'] }}</p>
            <span>— {{ $verse['ref'] }}</span>
            <button onclick="createCitationCard()" class="tag"
                style="position:absolute; right:1.5rem; bottom:1.5rem; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.2); color:white;">
                <i class="bi bi-instagram"></i> Card
            </button>
        </div>

        <div class="search-pill">
            <select id="bible-version">
                <option value="NVI">NVI</option>
                <option value="ARC">ARC</option>
                <option value="ARA">ARA</option>
                <option value="KJV">KJV</option>
            </select>
            <input type="text" id="query" placeholder="Dúvida teológica... ex: Graça"
                onkeypress="if(event.key==='Enter') performSearch()">
            <button class="btn-voice" id="voice-btn" onclick="startVoiceSearch()" title="Voz">
                <i class="bi bi-mic"></i>
            </button>
            <button class="btn-study" onclick="performSearch()">
                <i class="bi bi-search"></i>
            </button>
        </div>

        <div id="menu-sections" style="margin-bottom:3rem;">
            <div id="section-daily" class="daily-section" style="display:none;">
                <div class="section-header"><i class="bi bi-compass-fill"></i> Exploração Diária</div>
                <div class="daily-grid">
                    @foreach ($dailyTopics as $topic)
                        <div class="daily-card" onclick="searchFromLink('{{ $topic['name'] }}')">
                            <i class="bi {{ $topic['icon'] ?? 'bi-journal-text' }}"></i>
                            <span>{{ $topic['name'] }}</span>
                            <small>{{ $topic['desc'] ?? 'Aprofundamento nas escrituras.' }}</small>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="section-history" class="daily-section" style="display:none;">
                <div class="section-header"><i class="bi bi-clock-history"></i> Histórico Recente</div>
                <div id="history-list" class="daily-grid"></div>
            </div>

            <div id="section-favs" class="daily-section" style="display:none;">
                <div class="section-header"><i class="bi bi-heart-fill" style="color:#ef4444;"></i> Favoritos</div>
                <div id="fav-list" class="daily-grid"></div>
            </div>
        </div>

        <div id="loader" class="loader">
            <div class="pulse">
                <i class="bi bi-intersect" style="font-size:2.5rem; color:var(--primary);"></i>
            </div>
            <p
                style="color:var(--primary); font-size:0.8rem; font-weight:700; letter-spacing:5px; text-transform:uppercase;">
                Revelando Sabedoria
            </p>
        </div>

        <div id="results" style="display:none;">
            <div id="print-header" style="display:none; text-align:center; font-family:'Crimson Pro', serif;">
                <h1 style="font-size:3rem; margin-bottom:0.2rem;">Bible Intelligent Study</h1>
                <p
                    style="text-transform:uppercase; letter-spacing:10px; font-weight:700; color:#555; font-size:0.8rem;">
                    Relatório de Exegese Teológica</p>
                <div style="margin:2rem 0; border-top:1px solid #000; border-bottom:1px solid #000; padding:1rem 0;">
                    <p><strong>Pesquisador:</strong> Yuliano Silva</p>
                    <p><strong>Data de Emissão:</strong> <span id="print-date"></span></p>
                </div>
            </div>

            <article class="study-card">
                <h2 id="st-title"></h2>
                <div id="st-details"></div>

                <div style="margin-top:3rem;">
                    <div class="section-header"><i class="bi bi-bookmark-fill"></i> Referências</div>
                    <div id="st-verses" class="daily-grid"
                        style="grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));"></div>
                </div>

                <div style="margin-top:3rem;">
                    <div class="section-header"><i class="bi bi-lightbulb-fill"></i> Sugestões</div>
                    <div id="st-suggestions"></div>
                </div>

                <div id="st-application-box"
                    style="margin-top:3rem; padding:2rem; background:var(--bg); border-radius:24px; border-left:4px solid var(--primary);">
                    <h4
                        style="font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; color:var(--muted); margin-bottom:1rem;">
                        Aplicação Prática</h4>
                    <p id="st-application" style="font-size:1.1rem; line-height:1.6;"></p>
                </div>

                <div style="margin-top:4rem; display:flex; gap:1.2rem; flex-wrap:wrap; justify-content:center;">
                    <button id="btn-listen" class="btn-premium btn-audio" onclick="toggleAudio()">
                        <i class="bi bi-volume-up"></i> Ouvir Estudo
                    </button>
                    <button class="btn-premium btn-report" onclick="generateReport()">
                        <i class="bi bi-shield-check"></i> Exportar Relatório
                    </button>
                    <button id="btn-fav" class="btn-premium">
                        <i class="bi bi-star"></i> Favoritar
                    </button>
                    <button class="btn-premium" onclick="copyStudy()">
                        <i class="bi bi-share"></i> Compartilhar
                    </button>
                </div>

                <div id="st-videos-container"
                    style="margin-top:3rem; border-top:1px solid var(--border); padding-top:2rem;">
                    <a id="yt-search-btn" target="_blank"
                        style="text-decoration:none; display:flex; align-items:center; gap:0.8rem; color:#ef4444; font-weight:700; font-size:0.9rem; text-transform:uppercase;">
                        <i class="bi bi-youtube" style="font-size:1.5rem;"></i> Assistir aulas relacionadas
                    </a>
                </div>
            </article>
        </div>

        <button class="btn-zen" id="zen-trigger" onclick="toggleZen()"
            style="position:fixed; bottom:2rem; right:2rem; background:var(--primary); color:white; width:55px; height:55px; border-radius:50%; border:none; display:none; align-items:center; justify-content:center; font-size:1.5rem; transition:0.3s; box-shadow:var(--shadow);">
            <i class="bi bi-book"></i>
        </button>

        <!-- Hidden Card for Reliable Capture -->
        <div id="hidden-card-export" style="position:absolute; left:-9999px; top:-9999px;"></div>

        <footer>
            <p>&copy; 2026 - Bible Intelligent Study</p>
            <p>Design Premium por <a href="https://yuliano.onrender.com/" target="_blank">Yuliano Silva</a></p>
        </footer>
    </div>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            themeToggle.innerHTML = newTheme === 'light' ? '<i class="bi bi-sun"></i>' :
                '<i class="bi bi-moon"></i>';
            localStorage.setItem('theme', newTheme);
        });

        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        themeToggle.innerHTML = savedTheme === 'light' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>';

        function searchFromLink(text) {
            document.getElementById('query').value = text;
            performSearch();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        async function performSearch() {
            const query = document.getElementById('query').value;
            if (!query) return;

            document.getElementById('results').style.display = 'none';
            document.getElementById('loader').style.display = 'flex';

            try {
                const response = await fetch('/api/query', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        query: query,
                        version: document.getElementById('bible-version').value
                    })
                });

                const data = await response.json();
                console.log('Resposta completa da IA:', data);

                if (!data.answer) {
                    console.error('Estrutura de resposta inválida:', data);
                    return;
                }

                // Tratar erro de conteúdo banal enviado pela IA
                if (!response.ok) {
                    if (response.status === 429) {
                        Swal.fire({
                            title: 'Alta Demanda de Sabedoria',
                            html: 'A biblioteca digital está recebendo muitos acessos no momento. <br><br><small>Por favor, aguarde alguns instantes enquanto liberamos espaço nos manuscritos para sua consulta.</small>',
                            icon: 'info',
                            confirmButtonColor: 'var(--primary)',
                            confirmButtonText: 'Entendido'
                        });
                    } else {
                        throw new Error('Falha na conexão com os manuscritos sagrados.');
                    }
                    return;
                }

                displayResults(data);
            } catch (error) {
                console.error('Erro detalhado na conexão:', error);
            } finally {
                document.getElementById('loader').style.display = 'none';
            }
        }

        function displayResults(data) {
            let ans = data.answer || {};

            // Se a resposta for string (JSON não decodificado perfeitamente), tentamos parsing
            if (typeof ans === 'string') {
                try {
                    ans = JSON.parse(ans);
                } catch (e) {
                    ans = {
                        details: ans,
                        summary: 'Estudo Teológico'
                    };
                }
            }

            document.getElementById('results').style.display = 'block';
            document.getElementById('zen-trigger').style.display = 'flex';
            document.getElementById('print-date').innerText = new Date().toLocaleDateString('pt-BR');

            document.getElementById('st-title').innerText = ans.summary || 'Estudo Profundo';
            document.getElementById('st-details').innerHTML = (ans.details || 'Conteúdo em reflexão...').replace(/\n/g,
                '<br>');
            document.getElementById('st-application').innerText = ans.application ||
            'Aplicação prática em desenvolvimento.';

            const verseBox = document.getElementById('st-verses');
            verseBox.innerHTML = '';
            const verses = ans.verses_used || (data.results ? data.results.verses : []) || [];
            verses.forEach(ref => {
                const chip = document.createElement('div');
                chip.className = 'daily-card';
                chip.style.padding = '0.8rem';
                chip.style.textAlign = 'center';
                chip.innerHTML =
                    `<i class="bi bi-bookmark-fill" style="color:var(--primary); font-size:0.8rem;"></i><span style="font-size:0.75rem; font-weight:700;">${ref}</span>`;
                verseBox.appendChild(chip);
            });

            const suggBox = document.getElementById('st-suggestions');
            suggBox.innerHTML = '';
            const suggestions = ans.suggestions || data.study_suggestions || [];

            suggestions.forEach(s => {
                const tag = document.createElement('span');
                tag.className = 'tag';
                tag.innerText = s;
                tag.onclick = () => searchFromLink(s);
                suggBox.appendChild(tag);
            });

            // --- YouTube Fix ---
            const ytBtn = document.getElementById('yt-search-btn');
            const ytTerm = (ans.summary || 'bíblia') + ' teologia cristã';
            ytBtn.setAttribute('href', `https://www.youtube.com/results?search_query=${encodeURIComponent(ytTerm)}`);
            ytBtn.onclick = function(e) { 
                e.preventDefault(); 
                window.open(this.getAttribute('href'), '_blank'); 
            };

            window.scrollTo({
                top: document.getElementById('results').offsetTop - 30,
                behavior: 'smooth'
            });
        }

        // --- Proteção Web Anti-DevTools ---
        // 1. Desativar Clique Direito
       /* document.addEventListener('contextmenu', event => event.preventDefault());

        // 2. Desativar Atalhos comuns (F12, Ctrl+Shift+I, etc)
        document.onkeydown = function(e) {
            if (e.keyCode == 123) return false; // F12
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) return false;
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) return false;
            if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) return false;
            if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) return false;
        };

        // 3. Deteção de abertura de Consola (Ativa o ecrã de bloqueio)
        setInterval(function() {
            const before = new Date().getTime();
            debugger;
            const after = new Date().getTime();
            if (after - before > 100) {
                document.body.innerHTML =
                    '<div style="display:flex;align-items:center;justify-content:center;height:100vh;flex-direction:column;font-family:sans-serif;background:#0f172a;color:white;text-align:center;padding:2rem;"><h1>Ambiente Seguro Ativado</h1><p>O uso de ferramentas de diagnóstico não é permitido nesta plataforma.</p><button onclick="location.reload()" style="margin-top:1.5rem;padding:12px 24px;cursor:pointer;background:#6366f1;color:white;border:none;border-radius:4px;font-weight:600;">Recarregar Aplicação</button></div>';
            }
        }, 1000);*/

        function toggleMenuSection(section) {
            const sections = ['daily', 'history', 'favs'];
            const target = document.getElementById(`section-${section}`);
            const wasVisible = target.style.display === 'block';

            sections.forEach(s => {
                document.getElementById(`section-${s}`).style.display = 'none';
            });

            if (!wasVisible) {
                target.style.display = 'block';
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            
            if (section === 'history') renderHistory();
            if (section === 'favs') renderFavorites();
        }

        function saveToHistory(query) {
            let history = JSON.parse(localStorage.getItem('study_history') || '[]');
            if (!history.includes(query)) {
                history.unshift(query);
                if (history.length > 8) history.pop();
                localStorage.setItem('study_history', JSON.stringify(history));
            }
            renderHistory();
        }

        function renderHistory() {
            const history = JSON.parse(localStorage.getItem('study_history') || '[]');
            const list = document.getElementById('history-list');

            if (history.length > 0) {
                list.innerHTML = '';
                history.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'daily-card';
                    div.style.padding = '1.2rem';
                    div.innerHTML = `<i class="bi bi-clock-history"></i><span>${item}</span>`;
                    div.onclick = () => searchFromLink(item);
                    list.appendChild(div);
                });
            }
        }

        function shareStudy() {
            const title = document.getElementById('st-title').innerText;
            const text = `Confira este estudo bíblico profundo sobre "${title}" no Bible Intelligent Study!`;
            const url = window.location.href;

            if (navigator.share) {
                navigator.share({
                    title,
                    text,
                    url
                });
            } else {
                window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent(text + ' ' + url)}`);
            }
        }

        function copyStudy() {
            const title = document.getElementById('st-title').innerText;
            const details = document.getElementById('st-details').innerText;
            const app = document.getElementById('st-application').innerText;
            const fullText = `*${title}*\n\n${details}\n\n*Aplicação Prática:*\n${app}`;

            navigator.clipboard.writeText(fullText).then(() => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Estudo copiado para a área de transferência!'
                });
            });
        }

        // --- Áudio (Speech Synthesis) ---
        let speechInstance = null;
        let isSpeaking = false;

        function toggleAudio() {
            const btn = document.getElementById('btn-listen');
            if (!btn) return;

            if (isSpeaking) {
                window.speechSynthesis.cancel();
                isSpeaking = false;
                btn.innerHTML = '<i class="bi bi-volume-up"></i> Ouvir Estudo';
                btn.classList.remove('btn-report');
                return;
            }

            const title = document.getElementById('st-title').innerText;
            const details = document.getElementById('st-details').innerText;
            const app = document.getElementById('st-application').innerText;
            const textToRead = `${title}. ${details}. Aplicação Prática: ${app}`;

            speechInstance = new SpeechSynthesisUtterance(textToRead);
            speechInstance.lang = 'pt-BR';
            speechInstance.rate = 1.0;

            speechInstance.onstart = () => {
                isSpeaking = true;
                btn.innerHTML = '<i class="bi bi-stop-circle"></i> Parar Leitura';
                btn.classList.add('btn-report');
            };

            speechInstance.onerror = () => {
                isSpeaking = false;
                btn.innerHTML = '<i class="bi bi-volume-up"></i> Ouvir Estudo';
                btn.classList.remove('btn-report');
            };

            speechInstance.onend = () => {
                isSpeaking = false;
                btn.innerHTML = '<i class="bi bi-volume-up"></i> Ouvir Estudo';
                btn.classList.remove('btn-report');
            };

            window.speechSynthesis.speak(speechInstance);
        }

        // Parar áudio ao pesquisar algo novo
        if (typeof window.performSearchHooked === 'undefined') {
            const originalPerformSearch = performSearch;
            performSearch = async function() {
                window.speechSynthesis.cancel();
                isSpeaking = false;
                const query = document.getElementById('query').value;
                if (query) saveToHistory(query);
                await originalPerformSearch();
            };
            window.performSearchHooked = true;
        }

        function toggleZen() {
            document.body.classList.toggle('zen-active');
            const btn = document.getElementById('zen-trigger');
            if (document.body.classList.contains('zen-active')) {
                btn.innerHTML = '<i class="bi bi-x-lg"></i>';
                btn.style.background = '#64748b';
            } else {
                btn.innerHTML = '<i class="bi bi-book"></i>';
                btn.style.background = 'var(--primary)';
            }
        }

        function saveFavorite() {
            const title = document.getElementById('st-title').innerText;
            let favorites = JSON.parse(localStorage.getItem('study_favorites') || '[]');

            if (!favorites.includes(title)) {
                favorites.unshift(title);
                localStorage.setItem('study_favorites', JSON.stringify(favorites));
                Swal.fire({
                    icon: 'success',
                    title: 'Favoritado!',
                    text: 'Este estudo foi guardado nos seus favoritos.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
            renderFavorites();
        }

        function renderFavorites() {
            const favorites = JSON.parse(localStorage.getItem('study_favorites') || '[]');
            const list = document.getElementById('fav-list');

            if (favorites.length > 0) {
                list.innerHTML = '';
                favorites.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'daily-card';
                    div.style.padding = '1.2rem';
                    div.innerHTML = `<i class="bi bi-star-fill" style="color:#f59e0b;"></i><span>${item}</span>`;
                    div.onclick = () => searchFromLink(item);
                    list.appendChild(div);
                });
            }
        }

        // Delegar evento favorito
        document.getElementById('btn-fav').onclick = saveFavorite;

        // --- Pesquisa por Voz ---
        function startVoiceSearch() {
            const btn = document.getElementById('voice-btn');
            const input = document.getElementById('query');

            if (!('webkitSpeechRecognition' in window)) {
                Swal.fire('Erro', 'O seu navegador não suporta pesquisa por voz.', 'error');
                return;
            }

            const recognition = new webkitSpeechRecognition();
            recognition.lang = 'pt-BR';
            recognition.continuous = false;
            recognition.interimResults = false;

            recognition.onstart = () => {
                btn.classList.add('recording');
                input.placeholder = "Ouvindo a sua voz...";
            }

            recognition.onend = () => {
                btn.classList.remove('recording');
                input.placeholder = "Consulte o Saber Sagrado...";
            }

            recognition.onresult = (event) => {
                const text = event.results[0][0].transcript;
                input.value = text;
                performSearch();
            };

            recognition.onerror = (e) => {
                console.error('Erro voz:', e);
                Swal.fire('Aviso', 'Não consegui captar a sua voz. Tente novamente.', 'warning');
            }

            recognition.start();
        }

        // --- Gerar Relatório Profissional com QR Code ---
        function generateReport() {
            try {
                const qrContainer = document.getElementById('print-qrcode');
                qrContainer.innerHTML = '';

                if (typeof QRCode !== 'undefined') {
                    new QRCode(qrContainer, {
                        text: window.location.href,
                        width: 128,
                        height: 128,
                        colorDark: "#2c3e50",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }
                document.getElementById('print-url').innerText = window.location.href;
                document.getElementById('print-url').style.display = 'block';
            } catch (e) {
                console.error('Erro QR Code:', e);
            }

            setTimeout(() => {
                window.print();
            }, 500);
        }

        // --- Dicionário Teológico Instantâneo ---
        document.getElementById('st-details').addEventListener('dblclick', async (e) => {
            const selection = window.getSelection().toString().trim();
            if (selection.length < 3 || selection.length > 30) return;

            Swal.fire({
                title: `Definindo: ${selection}`,
                text: 'Consultando léxico teológico...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                const response = await fetch('/api/query', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        query: `Defina o termo teológico "${selection}" brevemente.`
                    })
                });
                const data = await response.json();
                Swal.fire({
                    title: selection,
                    text: data.answer.details || 'Definição não encontrada.',
                    confirmButtonColor: 'var(--primary)'
                });
            } catch (err) {
                Swal.close();
            }
        });

        // --- Citação do Dia para Redes Sociais ---
        function createCitationCard() {
            const verse = document.getElementById('daily-verse-text').innerText;
            const ref = document.querySelector('.verse-banner span').innerText;
            const siteUrl = "bible-study.onrender.com";

            const cardHtml = `
                <div id="citation-card" style="background:radial-gradient(circle at top right, #2d3748, #1a202c); color:white; padding:4rem 2rem; border-radius:12px; text-align:center; font-family:'Crimson Pro',serif; border:4px double rgba(212,175,55,0.4); box-shadow:0 30px 60px rgba(0,0,0,0.3); width:100%; max-width:450px; margin:0 auto; position:relative; overflow:hidden;">
                    <div style="position:absolute; top:1.5rem; left:50%; transform:translateX(-50%); font-size:0.6rem; text-transform:uppercase; letter-spacing:5px; color:rgba(212,175,55,0.6);">Pérola Sagrada</div>
                    <i class="bi bi-quote" style="font-size:3.5rem; color:#d4af37; opacity:0.8; display:block; margin-bottom:1rem;"></i>
                    <p style="font-size:1.6rem; font-style:italic; line-height:1.2; margin-bottom:2.5rem; font-weight:400; text-shadow:2px 2px 10px rgba(0,0,0,0.5);">${verse}</p>
                    <div style="display:inline-block; padding:0.6rem 2rem; background:rgba(212,175,55,0.1); border:1px solid rgba(212,175,55,0.3); border-radius:100px; color:#d4af37; font-weight:700; text-transform:uppercase; letter-spacing:4px; font-size:0.7rem;">${ref}</div>
                    
                    <div style="margin-top:4rem; border-top:1px solid rgba(255,255,255,0.1); padding-top:2rem;">
                        <p style="font-weight:700; letter-spacing:3px; font-size:0.9rem; color:#d4af37;">YULIANO SILVA</p>
                        <p style="font-size:0.6rem; color:rgba(255,255,255,0.4); margin-top:0.5rem; letter-spacing:2px;">${siteUrl}</p>
                    </div>
                </div>
            `;

            // Preparar o card oculto para captura
            document.getElementById('hidden-card-export').innerHTML = cardHtml;

            Swal.fire({
                title: 'Card de Sabedoria',
                html: cardHtml,
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-download"></i> Guardar Imagem',
                cancelButtonText: 'Fechar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const cardToCapture = document.querySelector('#hidden-card-export #citation-card');
                    
                    Swal.fire({
                        title: 'Gerando Imagem...',
                        didOpen: () => { Swal.showLoading(); }
                    });
                    
                    setTimeout(() => {
                        html2canvas(cardToCapture, {
                            scale: 2,
                            backgroundColor: '#1a202c'
                        }).then(canvas => {
                            const link = document.createElement('a');
                            link.download = `sabedoria-yuliano-${new Date().getTime()}.png`;
                            link.href = canvas.toDataURL('image/png');
                            link.click();
                            Swal.fire('Sucesso!', 'A imagem foi guardada.', 'success');
                        }).catch(err => {
                            console.error('Html2Canvas Error:', err);
                            Swal.fire('Erro', 'Não foi possível gerar a imagem fora do modal.', 'error');
                        });
                    }, 500);
                }
            });
        }

        // --- Inicialização ---
        renderHistory();
        renderFavorites();
    </script>
</body>

</html>
