<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMovie extends Model
{
    use HasFactory;

    protected $table = 'user_movies';

    protected $fillable = [
        'user_id',
        'movie_id',
        'status',
        'user_rating',
        'comment',
        'primary_img',
        'primary_title',
        'original_title',
        'start_year',
        'is_favourite'
    ];

    protected $casts = [
        'user_rating' => 'integer',
        'start_year' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeByStatus($query, $status){
        if($status){
            return $query->where('status', $status);
        }
        return $query;
    }


}
