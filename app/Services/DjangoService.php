<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class DjangoService{
    public function validateTask(array $data){
try {
        $res = Http::post(env('DJANGO_SERVICE_URL'), $data);
        return $res->json();
    } catch (\Exception $e) {
        return [
            'valid' => false,
            'message' => 'Rule engine unavailable'
        ];
    }



       
    }
}
