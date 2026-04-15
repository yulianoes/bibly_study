<!DOCTYPE html>
<html lang="pt-br" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página não encontrada - Bible Study</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root[data-theme="light"] {
            --bg: #f8fafc; --card-bg: #ffffff; --text: #1e293b; --muted: #64748b; --primary: #6366f1; --border: rgba(0,0,0,0.06);
        }
        :root[data-theme="dark"] {
            --bg: #0f172a; --card-bg: #1e293b; --text: #f1f5f9; --muted: #94a3b8; --primary: #818cf8; --border: rgba(255,255,255,0.06);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background: var(--bg); color: var(--text); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-card { background: var(--card-bg); padding: 3rem; border-radius: 4px; border: 1px solid var(--border); text-align: center; max-width: 400px; width: 90%; }
        .error-code { font-size: 5rem; font-weight: 600; background: linear-gradient(135deg, var(--primary), #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1; margin-bottom: 1rem; }
        .error-title { font-size: 1.5rem; margin-bottom: 0.5rem; }
        .error-desc { color: var(--muted); margin-bottom: 2rem; font-size: 0.95rem; }
        .btn-home { background: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: 600; transition: 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-home:hover { opacity: 0.9; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-code">404</div>
        <h1 class="error-title">Caminho não encontrado</h1>
        <p class="error-desc">A sabedoria que procura não se encontra nesta localização. Talvez tenha sido movida para outra página.</p>
        <a href="/" class="btn-home"><i class="bi bi-house"></i> Voltar ao Início</a>
    </div>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</body>
</html>
