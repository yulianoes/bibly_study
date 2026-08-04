<?php

namespace App\Jobs;

use App\Models\QueryLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Persiste analytics de uma pesquisa depois da resposta HTTP já ter sido
 * enviada ao utilizador.
 *
 * Este job é sempre despachado para a conexão 'background' (ver
 * config/queue.php), introduzida no Laravel 13. Essa conexão executa o job
 * num processo PHP separado sem depender de um worker persistente
 * (`queue:work`), o que permite manter o deploy no Render como um único
 * serviço web — sem custo extra de um dyno/worker dedicado.
 */
class LogBibleQueryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $query,
        public string $theme,
        public string $intent,
        public string $aiProvider,
        public bool $success,
        public int $durationMs,
    ) {}

    public function handle(): void
    {
        QueryLog::create([
            'query' => $this->query,
            'theme' => $this->theme,
            'intent' => $this->intent,
            'ai_provider' => $this->aiProvider,
            'success' => $this->success,
            'duration_ms' => $this->durationMs,
        ]);
    }
}
