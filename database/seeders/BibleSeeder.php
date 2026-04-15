<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BibleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Livros
        $genesis = \App\Models\Book::create(['name' => 'Gênesis', 'abbrev' => 'Gn', 'testament' => 'OT']);
        $joao = \App\Models\Book::create(['name' => 'João', 'abbrev' => 'Jo', 'testament' => 'NT']);
        $romanos = \App\Models\Book::create(['name' => 'Romanos', 'abbrev' => 'Rm', 'testament' => 'NT']);
        $hebreus = \App\Models\Book::create(['name' => 'Hebreus', 'abbrev' => 'Hb', 'testament' => 'NT']);

        // Temas
        $fe = \App\Models\Topic::create(['name' => 'Fé', 'slug' => 'fe']);
        $amor = \App\Models\Topic::create(['name' => 'Amor', 'slug' => 'amor']);
        $criacao = \App\Models\Topic::create(['name' => 'Criação', 'slug' => 'criacao']);
        $salvacao = \App\Models\Topic::create(['name' => 'Salvação', 'slug' => 'salvacao']);

        // Versículos
        $v1 = \App\Models\Verse::create([
            'book_id' => $hebreus->id,
            'chapter' => 11,
            'verse' => 1,
            'text' => 'Ora, a fé é o firme fundamento das coisas que se esperam, e a prova das coisas que se não veem.',
            'version' => 'NVI'
        ]);
        $v1->topics()->attach($fe->id);

        $v2 = \App\Models\Verse::create([
            'book_id' => $romanos->id,
            'chapter' => 10,
            'verse' => 17,
            'text' => 'De sorte que a fé é pelo ouvir, e o ouvir pela palavra de Deus.',
            'version' => 'NVI'
        ]);
        $v2->topics()->attach($fe->id);

        $v3 = \App\Models\Verse::create([
            'book_id' => $joao->id,
            'chapter' => 3,
            'verse' => 16,
            'text' => 'Porque Deus amou o mundo de tal maneira que deu o seu Filho unigênito, para que todo aquele que nele crê não pereça, mas tenha a vida eterna.',
            'version' => 'NVI'
        ]);
        $v3->topics()->attach([$amor->id, $salvacao->id]);

        $v4 = \App\Models\Verse::create([
            'book_id' => $genesis->id,
            'chapter' => 1,
            'verse' => 1,
            'text' => 'No princípio criou Deus os céus e a terra.',
            'version' => 'NVI'
        ]);
        $v4->topics()->attach($criacao->id);

        // Comentários
        \App\Models\Commentary::create([
            'verse_id' => $v1->id,
            'content' => 'Fé não é um sentimento, mas uma certeza baseada na fidelidade de Deus.',
            'source' => 'Estudo Geral'
        ]);

        \App\Models\Commentary::create([
            'verse_id' => $v3->id,
            'content' => 'Este é considerado o versículo áureo da Bíblia, resumindo o plano de redenção.',
            'source' => 'Comentário Devocional'
        ]);
    }
}
