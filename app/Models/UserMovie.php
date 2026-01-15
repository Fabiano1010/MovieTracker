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
    ];
    protected $casts = [
        'user_id' => 'integer',
        'added_at' => 'datetime',
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
