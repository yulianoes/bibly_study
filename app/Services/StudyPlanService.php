<?php

namespace App\Services;

class StudyPlanService
{
    public function generatePlan(array $context, string $query)
    {
        return [
            'theme' => "Estudo Especial sobre " . (ucfirst($query)),
            'main_verses' => collect($context['results']['verses'])->pluck('reference')->toArray(),
            'explanation' => "Um mergulho profundo no que a Bíblia diz sobre {$query}.",
            'reflection_questions' => [
                "Como você enxerga {$query} na sua vida hoje?",
                "O que o versículo mais impactante deste estudo ensinou a você?"
            ],
            'daily_plan' => [
                'Dia 1' => 'Leitura e Meditação inicial',
                'Dia 2' => 'Análise de contexto histórico',
                'Dia 3' => 'Aplicação prática e Oração'
            ]
        ];
    }
}
