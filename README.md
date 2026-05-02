# Bible Intelligent Study

Plataforma **open source** de estudo bíblico assistida por Inteligência Artificial. Permite ao utilizador colocar uma dúvida teológica (ou escolher um tema) e receber, em segundos, um estudo estruturado com resumo, desenvolvimento, versículos de apoio, aplicação prática, sugestões para aprofundamento e vídeos relacionados.

O projecto é mantido pela comunidade e está aberto a contribuições — novas funcionalidades, correcções, traduções, melhorias de interface, integração com novas fontes ou modelos de IA são bem-vindas. Ver a secção [Contribuir](#contribuir).

> _"A Alta Era da Erudição Teológica."_

---

## Índice

- [Visão geral](#visão-geral)
- [Funcionalidades](#funcionalidades)
- [Stack tecnológica](#stack-tecnológica)
- [Arquitectura](#arquitectura)
- [Endpoint da API](#endpoint-da-api)
- [Pré-requisitos](#pré-requisitos)
- [Instalação local](#instalação-local)
- [Variáveis de ambiente](#variáveis-de-ambiente)
- [Comandos úteis](#comandos-úteis)
- [Testes](#testes)
- [Deploy com Docker](#deploy-com-docker)
- [Estrutura de pastas](#estrutura-de-pastas)
- [Contribuir](#contribuir)
- [Autor](#autor)
- [Licença](#licença)

---

## Visão geral

A aplicação combina três fontes de conhecimento numa única experiência de pesquisa:

1. **IA generativa** — geração de estudos teológicos profundos via API Gemini (com fallback automático para OpenAI e, em último caso, conteúdo offline).
2. **Base bíblica local** — modelo relacional com livros, versículos, tópicos e comentários, indexado para pesquisa por palavra-chave ou tópico.
3. **Conteúdo externo** — sugestão automática de vídeos do YouTube relacionados com o tema pesquisado.

A interface foi desenhada para leitura confortável (modo zen, modo escuro, fontes serifadas para o corpo do estudo) e inclui ferramentas práticas como exportação de relatório com QR Code, narração por voz (TTS), pesquisa por voz e geração de cards para redes sociais.

---

## Funcionalidades

**Pesquisa & estudo**
- Geração de estudos por tema (`/api/query`) com cascata de modelos Gemini (`gemini-2.0-flash` → `gemini-2.0-flash-lite` → `gemini-flash-latest`) e _backoff_ exponencial em 429.
- Detecção automática de intenção (versículo, tema ou plano de estudo).
- Plano de estudo de 3 dias para pesquisas que pedem "plano" / "estudo" / "dias".
- _Fallback_ offline com versículos sugeridos quando todos os provedores de IA falham.

**Interface**
- Tema claro / escuro com persistência em `localStorage`.
- **Modo Zen** para leitura distrativa.
- Pesquisa por **voz** (Web Speech API).
- **Narração** do estudo via Speech Synthesis (PT-BR).
- Histórico e favoritos guardados localmente.
- Cache de resultados no cliente por chave `tema + versão`.
- Sanitização de _input_ contra XSS / SQLi (lista negra no cliente + validação no servidor).
- **Dicionário instantâneo** — duplo clique em qualquer palavra do estudo abre uma definição teológica.

**Exportação**
- Relatório imprimível em PDF com cabeçalho personalizado e QR Code para a URL.
- _Card_ de citação para redes sociais gerado com `html2canvas`.
- Cópia do estudo formatado para a área de transferência.

---

## Stack tecnológica

| Camada       | Tecnologia                                    |
|--------------|-----------------------------------------------|
| Backend      | Laravel 13, PHP 8.3                           |
| Auth         | Laravel Sanctum 4                             |
| Frontend     | Blade + Vanilla JS, Vite 8, Tailwind CSS 4    |
| UI libs      | Bootstrap Icons, SweetAlert2, html2canvas, qrcodejs |
| Base de dados| PostgreSQL (recomendado em produção) / SQLite (dev) |
| IA           | Google Gemini API (primário), OpenAI (fallback) |
| Testes       | Pest 4 + pest-plugin-laravel                  |
| PDF          | smalot/pdfparser                              |
| Container    | Docker (PHP 8.3 + Apache, multi-stage)        |

---

## Arquitectura

O fluxo de uma pesquisa segue cinco passos principais, orquestrados pelo `BibleController`:

```
[Cliente]
    │
    │ POST /api/query  { query, version }
    ▼
[BibleController::query]
    │
    ├─► AiExplanationService::extractKeywords()   (limpa frases > 3 palavras)
    ├─► IntentDetectionService::detect()          (verse | topic | study_plan)
    ├─► AiExplanationService::generate()          (Gemini → OpenAI → offline)
    ├─► YouTubeService::searchVideos()            (vídeos relacionados)
    └─► StudyPlanService::generatePlan()          (apenas se intent = study_plan)
    │
    ▼
{ answer, results, study_suggestions, videos, study_plan? }
```

**Serviços (`app/Services`)**

| Serviço                     | Responsabilidade                                          |
|-----------------------------|-----------------------------------------------------------|
| `AiExplanationService`      | Extracção de _keywords_ e geração do estudo via IA        |
| `IntentDetectionService`    | Classifica a pergunta em `verse`, `topic` ou `study_plan` |
| `BibleSearchService`        | Pesquisa local por versículos, tópicos e comentários      |
| `SemanticSearchService`     | Expansão semântica de termos (mapa de sinónimos)          |
| `StudyPlanService`          | Gera plano de estudo de 3 dias                            |
| `YouTubeService`            | Devolve vídeos sugeridos para o tema                      |

**Modelo de dados (`app/Models`)**

- `Book` — livro bíblico (nome, abreviatura, testamento)
- `Verse` — versículo (`book_id`, `chapter`, `verse`, `text`, `version`)
- `Topic` — tema teológico (`name`, `slug`) — N:N com `Verse`
- `Commentary` — comentário associado a um versículo
- `PdfContent` — conteúdo extraído de PDFs (suporte a futuro RAG)
- `User` — autenticação Sanctum

---

## Endpoint da API

### `POST /api/query`

**Request**
```json
{
  "query": "O que é a graça?",
  "version": "NVI"
}
```

**Validação**: `query` é obrigatório, mínimo 2 caracteres.

**Response (200)**
```json
{
  "answer": {
    "summary": "A graça é o favor imerecido de Deus...",
    "details": "Estudo completo em parágrafos...",
    "verses_used": ["Efésios 2:8", "Romanos 5:20"],
    "application": "Aplicação prática para a vida cristã...",
    "suggestions": ["Justificação pela fé", "Salvação", "..."]
  },
  "results": { "verses": [], "commentaries": [] },
  "study_suggestions": ["..."],
  "videos": [
    { "title": "...", "url": "...", "thumbnail": "..." }
  ],
  "study_plan": { /* presente apenas quando intent = study_plan */ }
}
```

---

## Pré-requisitos

- **PHP** ≥ 8.3 com extensões: `pdo_pgsql` (ou `pdo_sqlite`), `intl`, `zip`, `mbstring`
- **Composer** ≥ 2.x
- **Node.js** ≥ 20 + npm
- **Base de dados** PostgreSQL ≥ 14 (ou SQLite para desenvolvimento)
- Chave de API **Gemini** (obrigatória) — [Google AI Studio](https://aistudio.google.com/)
- Chave de API **OpenAI** (opcional, _fallback_)

---

## Instalação local

```bash
# 1. Clonar e entrar no projecto
git clone https://github.com/<utilizador>/bibly_study.git
cd bibly_study

# 2. Instalar dependências PHP e JS
composer install
npm install

# 3. Configurar ambiente
cp .env.example .env       # ou criar manualmente (ver secção abaixo)
php artisan key:generate

# 4. Criar a base de dados
touch database/database.sqlite     # se usar SQLite
php artisan migrate --seed         # corre migrations + BibleSeeder

# 5. Arrancar o ambiente de desenvolvimento (server + queue + Vite)
composer run dev
```

A aplicação ficará disponível em `http://localhost:8000`.

---

## Variáveis de ambiente

Variáveis essenciais para o `.env`:

```dotenv
APP_NAME="Bible Intelligent Study"
APP_ENV=local
APP_KEY=                         # gerada por php artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de dados (PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=bibly_study
DB_USERNAME=postgres
DB_PASSWORD=secret

# Cache / sessão (em produção stateless usar 'array')
CACHE_STORE=file
SESSION_DRIVER=file

# Inteligência Artificial
GEMINI_API_KEY=                  # obrigatório
OPENAI_API_KEY=                  # opcional, fallback
```

---

## Comandos úteis

| Comando                       | Descrição                                                  |
|-------------------------------|------------------------------------------------------------|
| `composer run dev`            | Arranca `php artisan serve`, `queue:listen` e `npm run dev` em paralelo |
| `composer run setup`          | Setup completo: install + key + migrate + build            |
| `composer run test`           | Limpa config + corre suite Pest                            |
| `npm run dev`                 | Vite em modo _watch_                                       |
| `npm run build`               | Build de produção dos assets                               |
| `php artisan migrate:fresh --seed` | Reset total da base de dados com seed                  |
| `php artisan tinker`          | REPL interactivo para inspeccionar modelos                 |
| `./vendor/bin/pint`           | Formatação automática do código (Laravel Pint)             |

---

## Testes

A suite usa **Pest 4** com plugin Laravel.

```bash
composer run test
# ou directamente:
./vendor/bin/pest
```

A configuração está em [`phpunit.xml`](phpunit.xml) e os testes em [`tests/`](tests/).

---

## Deploy com Docker

O projecto inclui um `dockerfile` _multi-stage_ pronto para plataformas como Render, Fly.io ou Railway.

```bash
docker build -t bibly-study .
docker run --rm -p 8080:80 \
  -e APP_KEY=base64:... \
  -e GEMINI_API_KEY=... \
  -e DB_CONNECTION=pgsql \
  -e DB_HOST=... \
  bibly-study
```

**Stages**:
1. **builder** (`php:8.3-cli`) — instala Composer, Node 20, dependências e corre `npm run build`.
2. **runtime** (`php:8.3-apache`) — Apache configurado para `public/`, OpCache afinado, copia _build_ do stage anterior.

O `entrypoint.sh` faz `config:cache`, `route:cache`, `view:cache` e `storage:link` no arranque, deixando a app pronta para servir em modo _stateless_.

---

## Estrutura de pastas

```
bibly_study/
├── app/
│   ├── Http/Controllers/      # BibleController (único endpoint)
│   ├── Models/                # Book, Verse, Topic, Commentary, PdfContent, User
│   └── Services/              # IA, intenção, busca, planos, YouTube
├── database/
│   ├── migrations/            # esquema (books, verses, topics, commentaries, pdf_contents)
│   └── seeders/               # BibleSeeder com dados iniciais
├── resources/
│   ├── views/welcome.blade.php  # SPA monolítica (Blade + Vanilla JS)
│   ├── css/app.css
│   └── js/app.js
├── routes/
│   ├── web.php                # rota '/' com tópicos diários rotativos
│   └── api.php                # POST /api/query
├── public/                    # entry point + assets estáticos + sitemap.xml
├── dockerfile                 # build multi-stage
└── entrypoint.sh              # script de arranque para containers
```

---

## Contribuir

Contribuições são muito bem-vindas! O projecto é open source e cresce com o envolvimento da comunidade. Algumas formas de contribuir:

- Reportar _bugs_ ou propor melhorias através de [_issues_](../../issues).
- Submeter _pull requests_ com correcções, novas funcionalidades ou refactorizações.
- Adicionar mais versículos, tópicos ou comentários ao `BibleSeeder`.
- Integrar novos provedores de IA, traduções da Bíblia ou línguas adicionais.
- Melhorar a documentação, a acessibilidade ou os testes.

**Fluxo recomendado**

1. Faz _fork_ do repositório.
2. Cria um _branch_ descritivo: `git checkout -b feat/nome-da-funcionalidade`.
3. Garante que o código segue o estilo do projecto: `./vendor/bin/pint`.
4. Garante que os testes passam: `composer run test`.
5. Faz _commit_ com mensagens claras e abre um _pull request_ contra `main`.

Para mudanças significativas, abre primeiro uma _issue_ a discutir a proposta — assim alinhamos a direcção antes do esforço de implementação.

## Autor

Criado e mantido por **[Yuliano Silva](https://yuliano.onrender.com/)** com a ajuda da comunidade.

## Licença

Distribuído sob a licença MIT — uso livre para fins pessoais, educativos ou comerciais. Ver [LICENSE](LICENSE) para detalhes.
