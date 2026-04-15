<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class YouTubeService
{
    public function searchVideos(string $keyword)
    {
        // Regra: Apenas conteúdo educativo/sermões
        $searchQuery = "{$keyword} estudo bíblico sermão";
        
        // Simulação de resposta (ou integração real se houver API_KEY)
        // Por agora, retornamos links genéricos baseados na busca para demonstração
        // IDs de vídeos reais e estáveis sobre temas bíblicos (Exemplo: Bible Project e similares)
        // Em um sistema real, aqui chamaríamos a API do YouTube
        return [
            [
                'title' => "O que é {$keyword}? (Visão Geral)",
                'url' => "https://www.youtube.com/watch?v=k_Zofm66D8E", // Exemplo real
                'thumbnail' => "https://img.youtube.com/vi/k_Zofm66D8E/hqdefault.jpg"
            ],
            [
                'title' => "Explicação Teológica: {$keyword}",
                'url' => "https://www.youtube.com/watch?v=VfNjhPkT_8E",
                'thumbnail' => "https://img.youtube.com/vi/VfNjhPkT_8E/hqdefault.jpg"
            ],
            [
                'title' => "Contexto Bíblico Profundo",
                'url' => "https://www.youtube.com/watch?v=d_id3m_Y_Yk",
                'thumbnail' => "https://img.youtube.com/vi/d_id3m_Y_Yk/hqdefault.jpg"
            ],
        ];
    }
}
