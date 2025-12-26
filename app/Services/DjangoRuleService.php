<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DjangoRuleService
{
    /**
     * Validate task status change via Django rule engine
     */
  public function validate(array $data)
{
    try {
        $response = Http::timeout(5)
            ->acceptJson()
            ->post(env('DJANGO_SERVICE_URL'), $data);

        return $response->json();

    } catch (\Exception $e) {
        return [
            'valid' => false,
            'message' => 'Rule engine unavailable'
        ];
    }
}

}
