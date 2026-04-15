<?php

namespace App\Services;

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
     * Extrai as palavras-chave principais de uma pergunta do utilizador.
     */
    public function extractKeywords(string $query): string
    {
        $geminiKey = env('GEMINI_API_KEY');
        $prompt = "Extraia APENAS as palavras-chave do tema bíblico a seguir, removendo verbos de comando como 'leia', 'explique', 'quero entender'. Retorne somente os termos essenciais separados por espaço, sem pontuação. Pergunta: {$query}";

        if ($geminiKey) {
            // Usa apenas o modelo mais rápido e leve para extração de keywords
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent?key={$geminiKey}";
            try {
                $response = Http::withoutVerifying()->timeout(8)->post($url, [
                    'contents' => [['parts' => [['text' => $prompt]]]]
                ]);
                if ($response->successful()) {
                    $text = $response->json('candidates.0.content.parts.0.text');
                    if ($text) return trim($text);
                }
            } catch (\Exception $e) {}
        }

        // Fallback manual robusto
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

        // --- GEMINI: Cascata com backoff exponencial ---
        if ($geminiKey) {
            $delay = 0; // segundos de espera entre tentativas

            foreach ($this->models as $index => $model) {
                if ($delay > 0) {
                    \Log::info("Aguardando {$delay}s antes de tentar '{$model}'...");
                    sleep($delay);
                }

                try {
                    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$geminiKey}";
                    $response = Http::withoutVerifying()->timeout(30)->post($url, [
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
                    ]);

                    if ($response->successful()) {
                        $text = $response->json('candidates.0.content.parts.0.text');
                        if ($text) {
                            \Log::info("✓ Sucesso com modelo '{$model}' para tema '{$query}'");
                            return $text;
                        }
                        \Log::warning("Modelo '{$model}' respondeu mas sem texto.");
                    } elseif ($response->status() === 429) {
                        $delay = ($index + 1) * 2; // backoff: 2s, 4s, 6s...
                        \Log::warning("429 em '{$model}'. Próximo em {$delay}s...");
                    } else {
                        \Log::warning("Erro {$response->status()} em '{$model}'. Tentando próximo...");
                    }

                } catch (\Exception $e) {
                    \Log::error("Exceção em '{$model}': " . $e->getMessage());
                }
            }

            \Log::error("Todos os modelos Gemini falharam para '{$query}'.");
        }

        // --- OPENAI (backup secundário) ---
        if ($openaiKey && $openaiKey !== 'sua_chave_aqui') {
            try {
                $response = Http::withoutVerifying()->withToken($openaiKey)->timeout(30)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4o-mini',
                        'messages' => [
                            ['role' => 'system', 'content' => $systemPrompt],
                            ['role' => 'user', 'content' => "Tema: {$query}"]
                        ],
                        'response_format' => ['type' => 'json_object']
                    ]);
                if ($response->successful()) {
                    return $response->json()['choices'][0]['message']['content'];
                }
            } catch (\Exception $e) {
                \Log::error("Exceção OpenAI: " . $e->getMessage());
            }
        }

        // --- BACKUP OFFLINE RICO ---
        \Log::warning("Usando backup offline para '{$query}'.");
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
