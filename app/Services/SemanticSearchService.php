<?php

namespace App\Services;

class SemanticSearchService
{
    /**
     * Simula uma IA que expande a busca original para termos semanticamente relacionados.
     */
    public function expandQuery(string $query)
    {
        $query = mb_strtolower($query);
        
        $map = [
            'jesus' => ['cristo', 'messias', 'salvador', 'filho de deus', 'cordeiro'],
            'amigo' => ['amizade', 'companheiro', 'próximo', 'irmão', 'comunhão'],
            'amizade' => ['amigo', 'união', 'vínculo', 'amor fraternal', 'comunhão'],
            'fé' => ['confiança', 'crer', 'certeza', 'fundamento', 'esperança'],
            'salvação' => ['redenção', 'vida eterna', 'libertação', 'graça'],
            'pecado' => ['transgressão', 'falha', 'iniquidade', 'erro'],
            'amor' => ['caridade', 'afeição', 'benevolência', 'agape'],
        ];

        return $map[$query] ?? [];
    }
}
