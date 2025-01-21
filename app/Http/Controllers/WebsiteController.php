<?php

namespace App\Http\Controllers;

use App\Services\ModrinthService;

class WebsiteController extends Controller
{
    protected $modrinthService;

    public function __construct(ModrinthService $modrinthService)
    {
        $this->modrinthService = $modrinthService;
    }

    private function getStats()
    {
        return [
            'discord_members' => '100+',
            'download_count' => $this->modrinthService->getDownloadCount(),
        ];
    }

    public function home()
    {
        return view('website.pages.homepage', [
            'stats' => $this->getStats(),
        ]);
    }

    public function features()
    {
        return view('website.pages.features', [
            'stats' => $this->getStats(),
        ]);
    }

    public function download()
    {
        return redirect("https://modrinth.com/plugin/openminetopia");
    }

    public function host()
    {
        return view('website.pages.host', [
            'stats' => $this->getStats(),
        ]);
    }
}
