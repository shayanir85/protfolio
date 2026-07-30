<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectPick;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProjectController extends Controller
{
    public function index()
    {
        $repos = ProjectPick::where('is_active', true)
            ->orderBy('display_order')
            ->pluck('repo_name');

        $projects = Cache::remember('github_projects', 3600, function () use ($repos) {
            return $repos->map(function ($repo) {
                return $this->fetchRepo($repo);
            })->filter()->values();
        });

        return response()->json(['projects' => $projects]);
    }

    private function fetchRepo(string $repo): ?array
    {
        $token = config('services.github.token');
        $url = "https://api.github.com/repos/{$repo}";

        $response = Http::withHeaders([
            'Accept' => 'application/vnd.github.v3+json',
            'Authorization' => $token ? "Bearer {$token}" : null,
            'User-Agent' => 'Portfolio-App',
        ])->get($url);

        if ($response->failed()) {
            return null;
        }

        $data = $response->json();

        return [
            'name' => $data['full_name'] ?? $repo,
            'description' => $data['description'] ?? '',
            'stars' => $data['stargazers_count'] ?? 0,
            'url' => $data['html_url'] ?? "https://github.com/{$repo}",
            'language' => $data['language'] ?? 'Unknown',
        ];
    }
}
