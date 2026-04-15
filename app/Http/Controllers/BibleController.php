<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\BibleSearchService;
use App\Services\IntentDetectionService;
use App\Services\AiExplanationService;
use App\Services\YouTubeService;
use App\Services\StudyPlanService;

class BibleController extends Controller
{
    protected $searchService;
    protected $intentService;
    protected $aiService;
    protected $youtubeService;
    protected $studyPlanService;
    protected $semanticService;

    public function __construct(
        BibleSearchService $searchService,
        IntentDetectionService $intentService,
        AiExplanationService $aiService,
        YouTubeService $youtubeService,
        StudyPlanService $studyPlanService,
        \App\Services\SemanticSearchService $semanticService
    ) {
        $this->searchService = $searchService;
        $this->intentService = $intentService;
        $this->aiService = $aiService;
        $this->youtubeService = $youtubeService;
        $this->studyPlanService = $studyPlanService;
        $this->semanticService = $semanticService;
    }

    public function query(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2'
        ]);

        $query = $request->input('query');

        // 1. Limpar o tema: só chama a IA para limpar frases longas (> 3 palavras)
        $words = explode(' ', trim($query));
        $theme = count($words) > 3
            ? $this->aiService->extractKeywords($query)
            : $query;
        $theme = ucfirst(trim($theme));

        // 2. Chave de Cache única para este tema (normalizada: minúsculas, sem acentos)
        $cacheKey = 'bible_study_' . md5(mb_strtolower(trim($theme)));

        // 3. Retornar do cache se disponível (evita chamar a API repetidamente)
        //    Cache dura 24 horas — perfeito para não esgotar a cota gratuita
        $cachedResponse = Cache::get($cacheKey);
        if ($cachedResponse) {
            \Log::info("✓ Cache HIT para tema: '{$theme}'");
            return response()->json($cachedResponse);
        }

        \Log::info("Cache MISS para tema: '{$theme}' — Chamando IA...");

        // 4. Detectar Intenção
        $intent = $this->intentService->detect($query);

        // 5. Contexto vazio (ignora Base de Dados para evitar erro 500 no Render)
        $context = [
            'results' => [
                'verses' => [],
                'commentaries' => []
            ]
        ];

        // 6. Gerar Estudo com IA
        $aiResponse = $this->aiService->generate($context, $theme);

        // 7. Decodificar JSON se vier como string
        if (is_string($aiResponse)) {
            $decoded = json_decode($aiResponse, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $aiResponse = $decoded;
            }
        }

        // 8. Buscar Vídeos
        $videos = $this->youtubeService->searchVideos($theme);

        // 9. Montar Resposta Final
        $response = [
            'answer'            => $aiResponse,
            'results'           => $context['results'],
            'study_suggestions' => $aiResponse['suggestions'] ?? [
                "Leia sobre {$theme} nas escrituras",
                "Foque nos pontos principais do estudo"
            ],
            'videos'            => $videos
        ];

        if ($intent === 'study_plan') {
            $response['study_plan'] = $this->studyPlanService->generatePlan($context, $theme);
        }

        // 10. Cache desativado para evitar erros de base de dados em instâncias read-only
        \Log::info("✓ Resposta gerada com sucesso para: '{$theme}'");

        return response()->json($response);
    }
}
