<!DOCTYPE html>
<html lang="pt-br" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Bible Intelligent Study</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

        @media (min-width: 600px) {
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

        @media print {
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

        @keyframes shimmer {
            100% { left: 100%; }
        }

        @keyframes pulse-text {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
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

        <div class="search-box">
            <input type="text" id="query" placeholder="Consulte o Saber Sagrado..."
                onkeypress="if(event.key === 'Enter') performSearch()">
            <button onclick="performSearch()">Pesquisar</button>
        </div>

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
                    alert(data.answer.error);
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
    </script>
</body>

</html>
