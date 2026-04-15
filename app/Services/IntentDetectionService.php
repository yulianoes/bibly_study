<?php

namespace App\Services;

class IntentDetectionService
{
    public function detect(string $query)
    {
        $queryLower = mb_strtolower($query);

        if (preg_match('/[a-zA-Z\s]+\s\d+:\d+/', $query)) {
            return 'verse';
        }

        if (str_contains($queryLower, 'plano') || str_contains($queryLower, 'estudo') || str_contains($queryLower, 'dias')) {
            return 'study_plan';
        }

        return 'topic';
    }
}
