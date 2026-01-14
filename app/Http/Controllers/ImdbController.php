<?php

namespace App\Http\Controllers;

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
            // Logowanie błędu
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

    public function getPopularMovies(Request $request){
        $request->validate([
            'country' => ['string'],
        ]);
        if($request->country == ''){
            $response = Http::get("https://api.imdbapi.dev/titles",[
                'types'=>'MOVIE',
                'sortBy'=>'SORT_BY_POPULARITY'
            ]);

        }else{
            $response = Http::get("https://api.imdbapi.dev/titles",[
                'types'=>'MOVIE',
                'sortBy'=>'SORT_BY_POPULARITY',
                'countryCodes'=>$request->country
            ]);
        }

        if ($response->successful()) {
            $data = $response->json();
            return Inertia::render('Movies/MoviesPopular', [
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
    public function getPopularTvSeries(Request $request){
        $request->validate([
            'country' => ['string'],
        ]);
        if($request->country == ''){
            $response = Http::get("https://api.imdbapi.dev/titles",[
                'types'=>'TV_SERIES',
                'sortBy'=>'SORT_BY_POPULARITY'
            ]);

        }else{
            $response = Http::get("https://api.imdbapi.dev/titles",[
                'types'=>'TV_SERIES',
                'sortBy'=>'SORT_BY_POPULARITY',
                'countryCodes'=>$request->country
            ]);
        }

        if ($response->successful()) {
            $data = $response->json();
            return Inertia::render('Dashboard', [
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
}

