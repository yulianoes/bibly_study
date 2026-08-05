<?php

namespace App\Services;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class AiExplanationService
{
    // Apenas modelos confirmados na models_list.txt (excluindo 1.5 que dão 404)
    private array $models = [
        'gemini-2.0-flash',
        'gemini-2.0-flash-lite',
        'gemini-flash-latest',
    ];

    /**
     * Tempo máximo (segundos) de espera por uma resposta de um único
     * modelo. Mantido baixo porque os modelos são chamados em paralelo
     * (ver generate()) — este valor passa a ser, na prática, o tempo
     * máximo total de espera pela IA, não a soma de várias tentativas.
     */
    private const REQUEST_TIMEOUT = 15;

    /**
     * Provedor que respondeu ao último pedido de generate(): 'gemini',
     * 'openai' ou 'offline'. Usado apenas para telemetria (ver
     * LogBibleQueryJob), não afecta a resposta devolvida ao cliente.
     */
    private string $lastProvider = 'offline';

    public function getLastProvider(): string
    {
        return $this->lastProvider;
    }

    /**
     * Extrai as palavras-chave principais de uma pergunta do utilizador.
     *
     * Propositadamente NÃO chama nenhuma API de IA: é apenas uma limpeza
     * local por regex. Fazer isto via IA custava uma chamada de rede
     * extra (até ~8s) ANTES de sequer começar a gerar o estudo,
     * praticamente duplicando o tempo total de resposta em pesquisas com
     * frases mais longas. Esta versão é instantânea.
     */
    public function extractKeywords(string $query): string
    {
        $stopWords = ['leia', 'explique', 'explicar', 'quem', 'foi', 'sobre', 'entender',
                      'quero', 'podes', 'fale', 'me', 'nos', 'estudo', 'falar', 'saiba',
                      'significa', 'o que', 'como', 'por que', 'porque', 'qual'];
        $clean = preg_replace('/\b(' . implode('|', $stopWords) . ')\b/iu', '', $query);
        $clean = trim(preg_replace('/\s+/', ' ', $clean));
        return $clean ?: $query;
    }

    /**
     * Gera um estudo bíblico profundo usando a IA (Gemini).
     */
    public function generate(array $context, string $query): array|string
    {
        $geminiKey = env('GEMINI_API_KEY');
        $openaiKey = env('OPENAI_API_KEY');

        $this->lastProvider = 'offline';

        \Log::info("AI Request para tema: '{$query}'");

        $systemPrompt = "Você é um ASSISTENTE TEOLÓGICO ESPECIALIZADO com profundo conhecimento da Bíblia.
        MISSÃO: Fornecer estudos bíblicos ricos, precisos e edificantes.
        REGRAS OBRIGATÓRIAS:
        1. Base sempre nas Escrituras — cite passagens específicas.
        2. Seja profundo mas acessível. Use linguagem clara e direta.
        3. Retorne ESTRITAMENTE em JSON válido com os campos: summary, details, verses_used, application, suggestions.
        4. 'summary': uma frase clara resumindo o tema (max 20 palavras).
        5. 'details': estudo completo e rico, mínimo 3 parágrafos.
        6. 'verses_used': array com referências bíblicas (ex: ['João 3:16', 'Salmos 23:1']).
        7. 'application': aplicação prática para a vida cristã hoje.
        8. 'suggestions': array com 4 temas bíblicos relacionados para aprofundamento.";

        // --- GEMINI: os 3 modelos são chamados EM PARALELO (não em cascata) ---
        // Cada modelo tem quota própria na API do Gemini, por isso não há
        // vantagem em esperar (sleep) entre tentativas — isso só somava
        // segundos ao tempo de resposta sem melhorar a taxa de sucesso.
        // Ao disparar os 3 de uma vez, o tempo total passa a ser o de UM
        // único pedido (o mais lento), em vez da soma de três.
        if ($geminiKey) {
            try {
                $responses = Http::pool(fn (Pool $pool) => array_map(
                    fn (string $model) => $pool->as($model)
                        ->withoutVerifying()
                        ->timeout(self::REQUEST_TIMEOUT)
                        ->post(
                            "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$geminiKey}",
                            [
                                'contents' => [
                                    ['parts' => [['text' => "Tema para estudo bíblico profundo: {$query}"]]]
                                ],
                                'system_instruction' => [
                                    'parts' => [['text' => $systemPrompt]]
                                ],
                                'generationConfig' => [
                                    'response_mime_type' => 'application/json',
                                    'temperature' => 0.7,
                                ]
                            ]
                        ),
                    $this->models
                ));
            } catch (\Exception $e) {
                \Log::error('Exceção ao disparar pedidos concorrentes ao Gemini: ' . $e->getMessage());
                $responses = [];
            }

            foreach ($this->models as $model) {
                $response = $responses[$model] ?? null;

                if (! $response instanceof Response) {
                    \Log::warning("Falha de conexão em '{$model}'.");
                    continue;
                }

                if ($response->successful()) {
                    $text = $response->json('candidates.0.content.parts.0.text');
                    if ($text) {
                        \Log::info("✓ Sucesso com modelo '{$model}' para tema '{$query}'");
                        $this->lastProvider = 'gemini';
                        return $text;
                    }
                    \Log::warning("Modelo '{$model}' respondeu mas sem texto.");
                } else {
                    \Log::warning("Erro {$response->status()} em '{$model}'.");
                }
            }

            \Log::error("Todos os modelos Gemini falharam para '{$query}'.");
        }

        // --- OPENAI (backup secundário) ---
        if ($openaiKey && $openaiKey !== 'sua_chave_aqui') {
            try {
                $response = Http::withoutVerifying()->withToken($openaiKey)->timeout(self::REQUEST_TIMEOUT)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4o-mini',
                        'messages' => [
                            ['role' => 'system', 'content' => $systemPrompt],
                            ['role' => 'user', 'content' => "Tema: {$query}"]
                        ],
                        'response_format' => ['type' => 'json_object']
                    ]);
                if ($response->successful()) {
                    $this->lastProvider = 'openai';
                    return $response->json()['choices'][0]['message']['content'];
                }
            } catch (\Exception $e) {
                \Log::error("Exceção OpenAI: " . $e->getMessage());
            }
        }

        // --- BACKUP OFFLINE RICO ---
        \Log::warning("Usando backup offline para '{$query}'.");
        $this->lastProvider = 'offline';
        return $this->generateOfflineFallback($query);
    }

    /**
     * Gera um conteúdo de backup rico quando a IA está indisponível.
     */
    private function generateOfflineFallback(string $query): array
    {
        return [
            'summary' => "Estudo sobre: {$query}",
            'details' => "⚠️ A Inteligência Artificial está temporariamente com limite de requisições atingido (Erro 429).\n\n"
                       . "O tema '{$query}' é de profunda riqueza nas Escrituras. "
                       . "Enquanto a conexão com a IA é restaurada (aguarde 5-10 minutos e pesquise novamente), "
                       . "recomendamos a leitura direta da Palavra de Deus nos versículos sugeridos abaixo.\n\n"
                       . "\"Toda a Escritura é inspirada por Deus e útil para o ensino, para a repreensão, "
                       . "para a correção e para a instrução na justiça.\" — 2 Timóteo 3:16",
            'verses_used' => ['2 Timóteo 3:16', 'Salmos 119:105', 'João 17:17'],
            'application' => "Use este momento para uma leitura bíblica direta e meditação sobre '{$query}'. A Palavra de Deus fala por si mesma.",
            'suggestions' => [
                "Aguarde 5 minutos e pesquise novamente sobre {$query}",
                "A fé que transforma — Hebreus 11",
                "O amor de Deus revelado — João 3",
                "Promessas de Deus para a sua vida — Jeremias 29:11"
            ]
        ];
    }
}
