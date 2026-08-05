<?php

use App\Jobs\LogBibleQueryJob;
use App\Models\QueryLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('persists a query log row when handled', function () {
    $job = new LogBibleQueryJob(
        query: 'O que é a graça?',
        theme: 'Graça',
        intent: 'topic',
        aiProvider: 'gemini',
        success: true,
        durationMs: 1234,
    );

    $job->handle();

    expect(QueryLog::count())->toBe(1);

    $log = QueryLog::first();
    expect($log->query)->toBe('O que é a graça?');
    expect($log->theme)->toBe('Graça');
    expect($log->intent)->toBe('topic');
    expect($log->ai_provider)->toBe('gemini');
    expect($log->success)->toBeTrue();
    expect($log->duration_ms)->toBe(1234);
});
