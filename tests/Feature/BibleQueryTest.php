<?php

use App\Jobs\LogBibleQueryJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

/**
 * env() resolves through Laravel's cached environment repository, which
 * reads $_ENV/$_SERVER (populated once at boot from .env) before falling
 * back to getenv(). To reliably override a value from within a test we
 * need to update all three so every adapter in the chain agrees.
 */
function setTestEnv(string $key, string $value): void
{
    putenv("{$key}={$value}");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

beforeEach(function () {
    setTestEnv('GEMINI_API_KEY', '');
    setTestEnv('OPENAI_API_KEY', '');
});

it('returns an offline fallback study and dispatches the analytics job on the background connection', function () {
    Queue::fake();

    $response = $this->postJson('/api/query', ['query' => 'graça']);

    $response->assertOk()
        ->assertJsonStructure([
            'answer' => ['summary', 'details', 'verses_used', 'application', 'suggestions'],
            'results' => ['verses', 'commentaries'],
            'study_suggestions',
            'videos',
        ]);

    Queue::assertPushed(LogBibleQueryJob::class, function (LogBibleQueryJob $job) {
        return $job->aiProvider === 'offline'
            && $job->success === false
            && $job->query === 'graça';
    });
});

it('dispatches the analytics job through the background queue connection', function () {
    Queue::fake();

    $this->postJson('/api/query', ['query' => 'fé']);

    Queue::assertPushed(LogBibleQueryJob::class, function (LogBibleQueryJob $job) {
        return $job->connection === 'background';
    });
});

it('uses gemini when an api key is configured and logs the provider used', function () {
    setTestEnv('GEMINI_API_KEY', 'fake-gemini-key');
    Queue::fake();

    $studyPayload = [
        'summary' => 'A fé é a certeza das coisas que se esperam.',
        'details' => 'Estudo completo sobre fé em três parágrafos...',
        'verses_used' => ['Hebreus 11:1'],
        'application' => 'Confie em Deus mesmo sem ver.',
        'suggestions' => ['Confiança', 'Esperança', 'Obediência', 'Perseverança'],
    ];

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [
                ['content' => ['parts' => [['text' => json_encode($studyPayload)]]]],
            ],
        ], 200),
    ]);

    $response = $this->postJson('/api/query', ['query' => 'fé']);

    $response->assertOk()
        ->assertJsonPath('answer.summary', $studyPayload['summary']);

    Queue::assertPushed(LogBibleQueryJob::class, function (LogBibleQueryJob $job) {
        return $job->aiProvider === 'gemini' && $job->success === true;
    });
});

it('still succeeds when the first-choice gemini model is rate limited, since models are tried concurrently', function () {
    setTestEnv('GEMINI_API_KEY', 'fake-gemini-key');

    Http::fake([
        'generativelanguage.googleapis.com/*gemini-2.0-flash:*' => Http::response([], 429),
        'generativelanguage.googleapis.com/*gemini-2.0-flash-lite*' => Http::response([
            'candidates' => [
                ['content' => ['parts' => [['text' => json_encode(['summary' => 'Resposta do segundo modelo'])]]]],
            ],
        ], 200),
        'generativelanguage.googleapis.com/*' => Http::response([], 429),
    ]);

    $response = $this->postJson('/api/query', ['query' => 'graça']);

    $response->assertOk()
        ->assertJsonPath('answer.summary', 'Resposta do segundo modelo');
});

it('extracts keywords locally and only performs the 3 concurrent generation requests, no separate keyword call', function () {
    setTestEnv('GEMINI_API_KEY', 'fake-gemini-key');

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [
                ['content' => ['parts' => [['text' => json_encode(['summary' => 'ok'])]]]],
            ],
        ], 200),
    ]);

    $response = $this->postJson('/api/query', ['query' => 'quero entender sobre a graça de Deus']);

    $response->assertOk();

    Http::assertSentCount(3);
});
