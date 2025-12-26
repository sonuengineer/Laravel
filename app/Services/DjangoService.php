<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DjangoRuleService
{
    public function validateTask(array $data)
    {
        try {
            $response = Http::timeout(5)->post(
                env('DJANGO_SERVICE_URL'),
                $data
            );

            if ($response->failed()) {
                return [
                    'valid' => false,
                    'message' => 'Rule engine rejected request'
                ];
            }

            return $response->json();

        } catch (\Exception $e) {
            return [
                'valid' => false,
                'message' => 'Rule engine unavailable'
            ];
        }
    }
}
