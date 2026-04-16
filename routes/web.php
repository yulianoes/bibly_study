<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $allTopics = [
        ['name' => 'Soteriologia', 'icon' => 'bi-heart-pulse', 'desc' => 'O estudo da salvação.'],
        ['name' => 'Escatologia', 'icon' => 'bi-clock-history', 'desc' => 'As últimas coisas.'],
        ['name' => 'Cristologia', 'icon' => 'bi-cross', 'desc' => 'A pessoa de Cristo.'],
        ['name' => 'Pneumatologia', 'icon' => 'bi-wind', 'desc' => 'A doutrina do Espírito Santo.'],
        ['name' => 'Eclesiologia', 'icon' => 'bi-house-heart', 'desc' => 'A doutrina da Igreja.'],
        ['name' => 'Santificação', 'icon' => 'bi-brightness-high', 'desc' => 'O processo de tornar-se santo.'],
        ['name' => 'Hermenêutica', 'icon' => 'bi-book', 'desc' => 'A arte da interpretação.'],
        ['name' => 'Exegese', 'icon' => 'bi-search', 'desc' => 'A extração do sentido original.'],
        ['name' => 'Natureza de Deus', 'icon' => 'bi-infinity', 'desc' => 'Atributos divinos.'],
        ['name' => 'Providência', 'icon' => 'bi-eye', 'desc' => 'O cuidado de Deus.'],
        ['name' => 'Graça Divina', 'icon' => 'bi-water', 'desc' => 'O favor imerecido.'],
        ['name' => 'Apologética', 'icon' => 'bi-shield-lock', 'desc' => 'A defesa da fé.'],
        ['name' => 'Trindade', 'icon' => 'bi-three-dots', 'desc' => 'Três pessoas, um só Deus.'],
        ['name' => 'Soberania', 'icon' => 'bi-crown', 'desc' => 'O governo absoluto de Deus.'],
        ['name' => 'Doutrina da Criação', 'icon' => 'bi-globe-europe-africa', 'desc' => 'A origem do universo.'],
        ['name' => 'Natureza Humana', 'icon' => 'bi-person-walking', 'desc' => 'Antropologia bíblica.'],
        ['name' => 'Justificação', 'icon' => 'bi-shield-check', 'desc' => 'Declarado justo por Deus.'],
        ['name' => 'Alianças Bíblicas', 'icon' => 'bi-link-45deg', 'desc' => 'Os pactos de Deus.'],
        ['name' => 'Parábolas', 'icon' => 'bi-chat-quote', 'desc' => 'Ensinos ocultos de Jesus.'],
        ['name' => 'Profecias', 'icon' => 'bi-megaphone', 'desc' => 'A mensagem dos profetas.'],
    ];

    // Seed based on day of month/year to rotate
    $day = (int) date('z');
    $count = count($allTopics);
    $dailyTopics = [];
    
    for($i = 0; $i < 4; $i++) {
        $dailyTopics[] = $allTopics[($day + $i) % $count];
    }

    $dailyVerses = [
        ['ref' => 'João 1:1', 'text' => 'No princípio era o Verbo, e o Verbo estava com Deus, e o Verbo era Deus.'],
        ['ref' => 'Salmos 119:105', 'text' => 'Lâmpada para os meus pés é tua palavra, e luz para o meu caminho.'],
        ['ref' => '2 Timóteo 3:16', 'text' => 'Toda a Escritura é divinamente inspirada, e proveitosa para ensinar.'],
        ['ref' => 'Hebreus 4:12', 'text' => 'Porque a palavra de Deus é viva e eficaz, e mais penetrante do que espada alguma.'],
        ['ref' => 'Colossenses 3:16', 'text' => 'A palavra de Cristo habite em vós abundantemente, em toda a sabedoria.'],
        ['ref' => 'Salmos 19:1', 'text' => 'Os céus declaram a glória de Deus e o firmamento anuncia a obra das suas mãos.'],
        ['ref' => 'Romanos 1:20', 'text' => 'Pois os seus atributos invisíveis são claramente vistos desde a criação do mundo.'],
    ];

    $verse = $dailyVerses[$day % count($dailyVerses)];

    return view('welcome', compact('dailyTopics', 'verse'));
});


