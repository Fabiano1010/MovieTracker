<?php

namespace App\Http\Controllers;

use App\Models\UserMovie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Inertia\Inertia;

class UserMovieController extends Controller
{
    public function index(Request $request){
        try{
            $user = Auth::user();
            $query = UserMovie::where('user_id',$user->id);
            if($request->has('status')){
                $validStatus=['to_watch','watched','in_progress'];
                $status=$request->input('status');

                if(in_array($status,$validStatus)){
                    $query->where('status',$status);
                }
            }
            if ($request->filled('is_favourite') && $request->boolean('is_favourite') == 1) {
                $query->where('is_favourite', $request->boolean('is_favourite'));
            }
            $sortBy=$request->input('sort_by', 'updated_at');
            $sortOrder=$request->input('sort_order', 'desc');
            $query->orderBy($sortBy, $sortOrder);
            $perPage = $request->input('per_page', 4);
            $movies = $query->paginate($perPage);

            return Inertia::render('Dashboard', [
                'movies' => $movies,
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred, please try again later.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function getByMovieId($movieId)
    {
        try {
            $user = Auth::user();


            $userMovie = UserMovie::where('user_id', $user->id)
                ->where('movie_id', $movieId)
                ->first();

//            if (!$userMovie) {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Movie not found in your collection.',
//                ], 404);
//            }


            $imdbController = new ImdbController();
            $imdbResponse = $imdbController->getTitleJson($movieId);


            if (!$imdbResponse || ($imdbResponse->getStatusCode() !== 200)) {
                \Log::warning('Failed to get IMDb data for movie', ['movie_id' => $movieId]);
                $imdbData = null;
            } else {
                $imdbContent = json_decode($imdbResponse->getContent(), true);
                $imdbData = $imdbContent['success'] ? $imdbContent['data'] : null;
            }



            return Inertia::render('Movies/MovieDetails', [

                'userMovie' => $userMovie,
                'movie' => $imdbData,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in getByMovieId', [
                'error' => $e->getMessage(),
                'movie_id' => $movieId,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred, please try again later.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'movie_id' => 'required|string|max:20',
                'primary_img'=> 'string|nullable',
                'primary_title'=> 'string|nullable',
                'original_title'=> 'string|nullable',
                'start_year' => 'nullable|integer|min:1900|max:' . date('Y')+5,
                'status' => 'sometimes|in:to_watch,watched,in_progress',
                'user_rating' => 'sometimes|integer|min:0|max:10|nullable',
                'comment' => 'sometimes|string|max:1000|nullable',
                'is_favourite'=> 'boolean',
            ], [
                'movie_id.required' => 'Movie id is required.',
                'movie_id.max' => 'Movie id is too long.',
                'status.in' => 'Incorrect status. Choose status.',
                'user_rating.min' => 'Rating has to be in range: 0-10',
                'user_rating.max' => 'Rating has to be in range: 0-10',
                'is_favourite.boolean' => 'Favourite must be true or false.',
            ]);

            if ($validator->fails()) {

                return back()->withErrors($validator)->withInput();

            }

            $user = Auth::user();


            $existingMovie = UserMovie::where('user_id', $user->id)
                ->where('movie_id', $request->movie_id)
                ->first();

            if ($existingMovie) {
                return Inertia::flash('error', 'This movie already is in collection.')->back();
            }
            $startYear = $request->start_year
                ? (int) $request->start_year
                : null;


            $userMovie = UserMovie::create([
                'user_id' => auth()->id(),
                'movie_id' => $request->movie_id,
                'primary_img' => $request->primary_img,
                'primary_title' => $request->primary_title,
                'original_title' => $request->original_title,
                'start_year' => $startYear,
                'status' => $request->status,
                'user_rating' => $request->user_rating,
                'comment' => $request->comment,
                'is_favourite' => $request->is_favourite ? 1 : 0
            ]);
            return Inertia::flash('success', 'Movie added successfully.')->back();


        } catch (\Exception $e) {
            return Inertia::flash('error', 'An error occurred while adding movie, please try again later.')->back();

        }
    }
    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'status' => 'sometimes|in:to_watch,watched,in_progress',
                'user_rating' => 'sometimes|integer|min:0|max:10|nullable',
                'comment' => 'sometimes|string|max:1000|nullable',
                'is_favourite'=> 'boolean',
            ]);

            if ($validator->fails()) {
                return Inertia::flash('error', 'Validation failed')->back();
            }

            $user = Auth::user();

            $userMovie = UserMovie::where('user_id', $user->id)
                ->where('movie_id', $id)
                ->first();

//            dd($request->all());
            $dataToUpdate = [];

            if ($request->has('status')) {
                $dataToUpdate['status'] = $request->status;
            }

            if ($request->has('user_rating')) {
                $dataToUpdate['user_rating'] = $request->user_rating;
            }

            if ($request->has('comment')) {
                $dataToUpdate['comment'] = $request->comment;
            }
            if ($request->has('is_favourite')) {
                $dataToUpdate['is_favourite'] = $request->is_favourite;
            }


            if (!empty($dataToUpdate)) {
                $userMovie->update($dataToUpdate);
            }
            return Inertia::flash('successUpdate', 'Movie updated.')->back();
//            return response()->json([
//                'success' => true,
//                'data' => $userMovie,
//                'message' => 'Movie updated successfully.'
//            ]);

        } catch (ModelNotFoundException $e) {
            return Inertia::flash('error', 'Movie not found')->back();
        } catch (\Exception $e) {
            return Inertia::flash('error', 'An error occurred while adding movie, please try again later.')->back();
        }
    }
    public function destroy($id): JsonResponse
    {
        try {
            $user = Auth::user();

            $userMovie = UserMovie::where('user_id', $user->id)
                ->findOrFail($id);

            $userMovie->delete();

            return response()->json([
                'success' => true,
                'message' => 'Movie deleted successfully.'
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Movie not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred, please try again later.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
    public function deleteByMovieId($movieId)
    {
        try {
            $user = Auth::user();

            $userMovie = UserMovie::where('user_id', $user->id)
                ->where('movie_id', $movieId)
                ->first();

            if (!$userMovie) {
                return Inertia::flash('error', 'Movie not found.')->back();

            }

            $userMovie->delete();
            return Inertia::flash('success', 'Movie deleted successfully.')->back();



        } catch (\Exception $e) {
            return Inertia::flash('error', 'An error occurred, please try again later.')->back();

        }
    }

    public function statistics()
    {
        try {
            $user = Auth::user();

            $stats = UserMovie::where('user_id', $user->id)
                ->selectRaw('COUNT(*) as total_movies')
                ->selectRaw('SUM(CASE WHEN status = "watched" THEN 1 ELSE 0 END) as watched_count')
                ->selectRaw('SUM(CASE WHEN status = "to_watch" THEN 1 ELSE 0 END) as to_watch_count')
                ->selectRaw('SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress_count')
                ->selectRaw('AVG(user_rating) as average_rating')
                ->selectRaw('SUM(CASE WHEN comment IS NOT NULL THEN 1 ELSE 0 END) as comment_count')
                ->selectRaw('SUM(CASE WHEN is_favourite = 1 THEN 1 ELSE 0 END) as fav_count')
                ->first();

            return Inertia::render('Statistics', [

                'stats' => $stats,
            ]);
//            return response()->json([
//                'success' => true,
//                'stats' => $stats,
//                'message' => 'Statistics retrieved successfully.'
//            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred, please try again later.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

}
