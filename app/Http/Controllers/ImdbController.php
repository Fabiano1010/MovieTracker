<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use function Pest\Laravel\deleteJson;

class ImdbController extends Controller
{
    protected $baseUrl;

    public function __construct(){
        $this->baseUrl = config('services.imdb.base_url', 'https://imdbapi.dev/');

    }
    public function search(Request $request){

        $request->validate([
            'title' => ['required', 'string','min:2'],
        ]);
        $response = Http::get('https://api.imdbapi.dev/search/titles', [
            'query' => $request->title,
        ]);

        if ($response->successful()) {
            $data=json_encode([]);
            $data = $response->json();
            return Inertia::render('Movies/Search', [
                'movies' => $data,
            ]);
        }

        if ($response->failed()) {
            \Log::error('API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        }
    }


    public function getTitle(Request $request)
    {
        $request->validate([
            'id' => ['required', 'string'],
        ]);
        $response = Http::get("https://api.imdbapi.dev/titles/{$request->id}");
        if ($response->successful()) {
            $data = $response->json();
            return Inertia::render('', [
                'movies' => $data,
            ]);
        }

        if ($response->failed()) {
            // Logowanie błędu
            \Log::error('API request failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        }
    }

    public function getPopular(Request $request)
    {
        $request->validate([
            'country' => ['nullable', 'string', 'size:2'],
        ]);

        $country = $request->country ?: '';
        $cacheKey = 'popular_movies_' . ($country ?: 'global');


        if (Cache::has($cacheKey)) {
            $data = Cache::get($cacheKey);
            \Log::info('Movies have been taken from cache', ['country' => $country]);

            return Inertia::render('Home', [
                'movies' => $data,
                'from_cache' => true,
                'cache_expires' => now()->addHour()->diffForHumans()
            ]);
        }

        try {
            $params = [
                'types' => ['MOVIE', 'TV_SERIES', 'TV_MINI_SERIES'],
                'sortBy' => 'SORT_BY_POPULARITY',
            ];

            if ($country) {
                $params['countryCodes'] = $country;
            }

            $response = Http::timeout(30)->get("https://api.imdbapi.dev/titles", $params);

            if ($response->successful()) {
                $data = $response->json();


                Cache::put($cacheKey, $data, 3600);
                \Log::info('Movies saved to cache', [
                    'country' => $country,
                    'count' => count($data['titles'] ?? [])
                ]);

                return Inertia::render('Home', [
                    'movies' => $data,
                    'from_cache' => false
                ]);
            }


            \Log::error('API request failed', [
                'status' => $response->status(),
                'country' => $country
            ]);

            return Inertia::render('Home', [
                'movies' => ['titles' => []],
                'error' => 'Failed to load movies from API.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Exception in getPopular: ' . $e->getMessage(), [
                'country' => $country
            ]);

            return Inertia::render('Home', [
                'movies' => ['titles' => []],
                'error' => 'Connection error. Please try again.'
            ]);
        }

    }
}

