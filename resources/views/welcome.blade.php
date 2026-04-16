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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root[data-theme="light"] {
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text: #1e293b;
            --muted: #64748b;
            --primary: #6366f1;
            --primary-glow: rgba(99, 102, 241, 0.15);
            --border: rgba(0, 0, 0, 0.06);
        }

        :root[data-theme="dark"] {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text: #f1f5f9;
            --muted: #94a3b8;
            --primary: #818cf8;
            --primary-glow: rgba(129, 140, 248, 0.2);
            --border: rgba(255, 255, 255, 0.06);
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
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        /* Navbar */
        .nav {
            display: flex;
            justify-content: flex-end;
            padding: 0.5rem 0;
        }

        .theme-toggle {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 4px;
            cursor: pointer;
            color: var(--text);
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        header {
            text-align: center;
            margin-bottom: 2.5rem;
            padding: 0 1rem;
        }

        h1 {
            font-size: clamp(2rem, 8vw, 3.2rem);
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary), #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }

        .subtitle {
            color: var(--muted);
            font-size: clamp(0.9rem, 4vw, 1.15rem);
            font-weight: 300;
        }

        /* Mobile-First Search Box */
        .search-box {
            background: var(--card-bg);
            padding: 0.5rem;
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            border: 1px solid var(--border);
            margin-bottom: 2.5rem;
            position: sticky;
            top: 15px;
            z-index: 1000;
        }

        @@media (min-width: 600px) {
            .search-box {
                flex-direction: row;
                border-radius: 4px;
                padding: 0.4rem;
            }
        }

        .search-box input {
            flex: 1;
            border: none;
            padding: 1.1rem 1.5rem;
            font-size: 1.1rem;
            outline: none;
            background: transparent;
            color: var(--text);
            border-radius: 4px;
        }

        .search-box button {
            background: var(--primary);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }

        @media (min-width: 600px) {
            .search-box button {
                border-radius: 4px;
            }
        }

        /* Card and Reports */
        .card {
            background: var(--card-bg);
            border-radius: 4px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
        }

        @media (min-width: 600px) {
            .card {
                padding: 2.5rem;
            }
        }

        #print-header {
            display: none;
        }

        @@media print {
            body {
                background: white !important;
                color: black !important;
            }

            #print-header {
                display: block;
                text-align: center;
                border-bottom: 2px solid #000;
                margin-bottom: 2rem;
                padding-bottom: 1rem;
            }

            .nav,
            .search-box,
            .theme-toggle,
            .btn-export,
            .tag,
            #st-videos-container,
            footer,
            h2:not(#st-title) {
                display: none !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                width: 100% !important;
            }

            .container {
                max-width: 100% !important;
                padding: 0 !important;
            }

            .ref-chip {
                border: 1px solid #ccc !important;
                color: black !important;
            }
        }

        .loader {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 3rem auto;
            gap: 1.5rem;
        }

        .loader-shimmer {
            width: 80px;
            height: 4px;
            background: var(--border);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .loader-shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            animation: shimmer 1.5s infinite;
        }

        .loader-text {
            font-size: 0.9rem;
            color: var(--primary);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            animation: pulse-text 1.5s infinite;
        }

        @@keyframes shimmer {
            100% {
                left: 100%;
            }
        }

        @@keyframes pulse-text {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .tag {
            padding: 0.6rem 1rem;
            background: var(--primary-glow);
            color: var(--primary);
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            cursor: pointer;
        }

        .ref-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 0.8rem;
            margin-top: 1rem;
        }

        .ref-chip {
            padding: 0.7rem;
            background: var(--bg);
            border-radius: 4px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            border: 1px solid var(--border);
        }

        .btn-export {
            background: #10b981;
            color: white;
            border: none;
            padding: 0.9rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            width: 100%;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
        }

        .btn-yt-search {
            background: #ef4444;
            color: white;
            text-decoration: none;
            padding: 1.1rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            font-weight: 600;
            margin-top: 1rem;
        }

        footer {
            text-align: center;
            padding: 2.5rem 0;
            color: var(--muted);
            font-size: 0.85rem;
            border-top: 1px solid var(--border);
        }

        footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        /* Daily Topics Section */
        .daily-section {
            margin-bottom: 2.5rem;
        }

        .daily-section h3 {
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .daily-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }

        @media (min-width: 600px) {
            .daily-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 1.2rem;
            }
        }

        .daily-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            padding: 1rem;
            border-radius: 4px;
            /* Mantendo consistência com o resto do site */
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 0.6rem;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 600px) {
            .daily-card {
                padding: 1.5rem;
                align-items: flex-start;
                text-align: left;
            }
        }

        .daily-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            box-shadow: 0 12px 24px -10px var(--primary-glow);
        }

        .daily-card i {
            font-size: 1.6rem;
            color: var(--primary);
            background: var(--primary-glow);
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .daily-card span {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text);
        }

        .daily-card small {
            color: var(--muted);
            font-size: 0.7rem;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Verse of the Day */
        .verse-banner {
            background: linear-gradient(135deg, var(--primary), #4f46e5);
            color: white;
            padding: 1.5rem;
            border-radius: 4px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .verse-banner::before {
            content: '“';
            position: absolute;
            top: -10px;
            left: 10px;
            font-size: 5rem;
            opacity: 0.1;
            font-family: serif;
        }

        .verse-banner p {
            font-size: 1.1rem;
            font-style: italic;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .verse-banner span {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        /* Recent Searches */
        .history-section {
            margin-top: 2rem;
            display: none;
        }

        .history-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.8rem;
        }

        .history-item {
            background: var(--card-bg);
            border: 1px solid var(--border);
            padding: 0.5rem 0.8rem;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .history-item:hover {
            background: var(--primary-glow);
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Share Button */
        .btn-share {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
            padding: 0.8rem 1.2rem;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            transition: 0.3s;
        }

        .btn-share:hover {
            background: var(--primary);
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="nav">
            <button class="theme-toggle" id="theme-toggle"><i class="bi bi-sun"></i></button>
        </nav>

        <header>
            <h1>Bible Intelligent Study</h1>
            <p class="subtitle">Alta erudição: Teologia</p>
        </header>

        <div class="verse-banner">
            <p>{{ $verse['text'] }}</p>
            <span>— {{ $verse['ref'] }}</span>
        </div>

        <div class="search-box">
            <input type="text" id="query" placeholder="Consulte o Saber Sagrado..."
                onkeypress="if(event.key === 'Enter') performSearch()">
            <button onclick="performSearch()">Pesquisar</button>
        </div>

        <section class="daily-section">
            <h3>Exploração Diária</h3>
            <div class="daily-grid">
                @foreach ($dailyTopics as $topic)
                    <div class="daily-card" onclick="searchFromLink('{{ $topic['name'] }}')">
                        <i class="bi {{ $topic['icon'] }}"></i>
                        <span>{{ $topic['name'] }}</span>
                        <small>{{ $topic['desc'] }}</small>
                    </div>
                @endforeach
            </div>

            <div id="history-container" class="history-section">
                <h3 style="font-size: 0.85rem;">Pesquisas Recentes</h3>
                <div id="history-list" class="history-list"></div>
            </div>
        </section>

        <div id="loader" class="loader">
            <div class="loader-shimmer"></div>
            <div class="loader-text">Consultando Saber Sagrado...</div>
        </div>

        <div id="results" style="display: none;">
            <!-- Cabeçalho de Impressão -->
            <div id="print-header">
                <h2>Relatório de estudo teológico profissional</h2>
                <p>Extraído em: <span id="print-date"></span></p>
                <p>Desenvolvido por <a href="https://yuliano.onrender.com/" target="_blank">Yuliano Silva</a></p>
            </div>

            <button class="btn-export" onclick="window.print()"><i class="bi bi-printer"></i> Exportar PDF</button>

            <div id="answer-card-container" class="card">
                <h2 id="st-title">Estudo profundo</h2>
                <div id="st-details" style="font-size: 1.1rem; line-height: 1.8;"></div>

                <h3 style="margin-top: 2rem; font-size: 0.85rem; color: var(--muted); text-transform: uppercase;">
                    Referências citadas</h3>
                <div id="st-verses" class="ref-grid"></div>

                <div
                    style="margin-top: 2rem; padding: 1.5rem; background: var(--primary-glow); border-radius: 4px; border: 1px solid var(--primary);">
                    <h4 style="color: var(--primary); font-weight: 700; text-transform: uppercase; font-size: 0.9rem;">
                        Aplicação prática</h4>
                    <p id="st-application" style="margin-top: 0.5rem; font-size: 1rem;"></p>
                </div>

                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <button class="btn-share" onclick="shareStudy()"><i class="bi bi-share"></i> Partilhar
                        Estudo</button>
                    <button class="btn-share" style="border-color: #f59e0b; color: #f59e0b;" id="btn-listen"
                        onclick="toggleAudio()"><i class="bi bi-volume-up"></i> Ouvir Estudo</button>
                    <button class="btn-share" style="border-color: #64748b; color: #64748b;" onclick="copyStudy()"><i
                            class="bi bi-clipboard"></i> Copiar Texto</button>
                </div>
            </div>

            <div class="card">
                <h2>Caminhos de Estudo</h2>
                <div id="st-suggestions" style="display: flex; flex-wrap: wrap; gap: 0.7rem;"></div>
            </div>

            <div class="card" id="st-videos-container">
                <h2>Pesquisa Multimedia</h2>
                <a id="yt-search-btn" href="#" target="_blank" class="btn-yt-search">
                    <i class="bi bi-youtube"></i> Pesquisar bibliografia em vídeo
                </a>
            </div>
        </div>

        <footer>
            <p>&copy; 2026 - Bible Study</p>
            <p>Desenvolvido por <a href="https://yuliano.onrender.com/" target="_blank">Yuliano Silva</a></p>
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
                        query: query
                    })
                });

                const data = await response.json();
                console.log('Resposta completa da IA:', data);

                if (!data.answer) {
                    console.error('Estrutura de resposta inválida:', data);
                    return;
                }

                // Tratar erro de conteúdo banal enviado pela IA
                if (data.answer.error) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Aviso Teológico',
                        text: data.answer.error,
                        confirmButtonColor: '#6366f1'
                    });
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
            const ans = data.answer || {};
            document.getElementById('results').style.display = 'block';
            document.getElementById('print-date').innerText = new Date().toLocaleDateString('pt-BR');

            document.getElementById('st-title').innerText = ans.summary || 'Estudo Teológico';
            document.getElementById('st-details').innerHTML = (ans.details || 'Sem detalhes disponíveis.').replace(/\n/g,
                '<br>');
            document.getElementById('st-application').innerText = ans.application || 'Aplicação não gerada.';

            const verseBox = document.getElementById('st-verses');
            verseBox.innerHTML = '';
            (data.answer.verses_used || []).forEach(ref => {
                const chip = document.createElement('div');
                chip.className = 'ref-chip';
                chip.innerHTML = `<i class="bi bi-bookmark text-primary me-2"></i> ${ref}`;
                verseBox.appendChild(chip);
            });

            const suggBox = document.getElementById('st-suggestions');
            suggBox.innerHTML = '';
            (data.study_suggestions || []).forEach(s => {
                const tag = document.createElement('span');
                tag.className = 'tag';
                tag.innerText = s;
                tag.onclick = () => searchFromLink(s);
                suggBox.appendChild(tag);
            });

            const ytBtn = document.getElementById('yt-search-btn');
            ytBtn.href =
                `https://www.youtube.com/results?search_query=${encodeURIComponent(data.answer.summary + ' teologia filosofia')}`;

            window.scrollTo({
                top: document.getElementById('results').offsetTop - 30,
                behavior: 'smooth'
            });
        }

        // --- Proteção Web Anti-DevTools ---
        // 1. Desativar Clique Direito
        document.addEventListener('contextmenu', event => event.preventDefault());

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
        }, 1000);

        // --- Novas Funcionalidades ---
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
            const container = document.getElementById('history-container');
            const list = document.getElementById('history-list');

            if (history.length > 0) {
                container.style.display = 'block';
                list.innerHTML = '';
                history.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'history-item';
                    div.innerHTML = `<i class="bi bi-clock-history"></i> ${item}`;
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

            if (isSpeaking) {
                window.speechSynthesis.cancel();
                isSpeaking = false;
                btn.innerHTML = '<i class="bi bi-volume-up"></i> Ouvir Estudo';
                btn.style.background = 'transparent';
                btn.style.color = '#f59e0b';
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
                btn.innerHTML = '<i class="bi bi-stop-circle"></i> Parar Áudio';
                btn.style.background = '#f59e0b';
                btn.style.color = 'white';
            };

            speechInstance.onend = () => {
                isSpeaking = false;
                btn.innerHTML = '<i class="bi bi-volume-up"></i> Ouvir Estudo';
                btn.style.background = 'transparent';
                btn.style.color = '#f59e0b';
            };

            window.speechSynthesis.speak(speechInstance);
        }

        // Parar áudio ao pesquisar algo novo
        const originalPerformSearch = performSearch;
        performSearch = async function() {
            window.speechSynthesis.cancel();
            isSpeaking = false;
            const query = document.getElementById('query').value;
            if (query) saveToHistory(query);
            await originalPerformSearch();
        };

        // Inicializar histórico ao carregar
        renderHistory();
    </script>
</body>

</html>
