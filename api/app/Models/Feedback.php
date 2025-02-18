<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Category;
use  App\Models\User;
use  App\Models\Comment;

class Feedback extends Model
{
    use HasFactory;

    protected $table = "feedbacks";

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'user_id'
    ];

    public static function scopeListingInfo($query)
    {
        return $query->with(['category','user'])->withCount('comments');
    }

    public function scopeSingleInfo($query)
    {
        return $query->with(['category','user'])->withCount('comments');
    }

    public function scopeFilters($query, array $data)
    {
        return $query;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
