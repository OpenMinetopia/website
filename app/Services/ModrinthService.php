<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ModrinthService
{
    protected $projectId = 'openminetopia';

    public function getDownloadCount()
    {
        return Cache::remember('modrinth_download_count', 300, function () {
            try {
                $response = Http::get("https://api.modrinth.com/v2/project/{$this->projectId}");

                if ($response->successful()) {
                    return number_format($response->json('downloads'));
                }
            } catch (\Exception $e) {
            }

            return '72';
        });
    }
}
