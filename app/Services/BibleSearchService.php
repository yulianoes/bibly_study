<?php

namespace App\Services;

use App\Models\Verse;
use App\Models\Topic;
use App\Models\Commentary;
use Illuminate\Support\Facades\DB;

class BibleSearchService
{
    public function search(string $terms)
    {
        $originalQuery = trim($terms);
        $keywords = explode(' ', mb_strtolower($originalQuery));

        // 1. Tentar encontrar tópicos
        $topics = Topic::where(function($q) use ($keywords) {
            foreach($keywords as $word) {
                $q->orWhere('name', 'like', "%{$word}%");
            }
        })->get();

        $topicIds = $topics->pluck('id');

        // 2. Buscar versículos
        $versesQuery = Verse::with(['book', 'topics']);
        $versesQuery->where(function($q) use ($topicIds, $keywords) {
            if ($topicIds->isNotEmpty()) {
                $q->whereHas('topics', function ($sq) use ($topicIds) {
                    $sq->whereIn('topics.id', $topicIds);
                });
            }
            foreach($keywords as $word) {
                $q->orWhere('text', 'like', "%{$word}%");
            }
        });

        $verses = $versesQuery->take(5)->get();

        // 3. DESATIVADO: Busca nos PDFs (Discartado a pedido do usuário)
        /*
        $pdfResultsQuery = \App\Models\PdfContent::query();
        foreach($keywords as $word) {
            if (strlen($word) > 2) { $pdfResultsQuery->orWhere('content', 'like', "%{$word}%"); }
        }
        $pdfResults = $pdfResultsQuery->take(5)->get();
        */
        $pdfResults = collect();

        // 4. Buscar comentários (apenas banco estruturado)
        $verseIds = $verses->pluck('id');
        $commentaries = Commentary::whereIn('verse_id', $verseIds)
            ->get()
            ->pluck('content')
            ->toArray();
        
        // Não há mais snippets de PDF aqui

        return [
            'query' => $terms,
            'type' => $topics->isNotEmpty() ? 'topic' : 'keyword',
            'results' => [
                'verses' => $verses->map(function ($v) {
                    return [
                        'reference' => "{$v->book->name} {$v->chapter}:{$v->verse}",
                        'text' => $v->text
                    ];
                })->toArray(),
                'topics' => $topics->pluck('name')->toArray(),
                'commentaries' => $commentaries,
                'has_pdf_context' => $pdfResults->isNotEmpty()
            ]
        ];
    }
}
