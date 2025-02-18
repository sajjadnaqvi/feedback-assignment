<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\User;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";

    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'content',
        'date',
        'user_id'
    ];

    public function scopeListingInfo($query)
    {
        return $query->with([
            'user',
            'mentions' => function($q){
                $q->select('first_name','last_name');
            }
        ]
        );
    }
    
    public function scoeMentionNames($query)
    {
        return $query;
    }

    public function scopeSingleInfo($query)
    {
        return $query->with([
            'user',
            'mentions' => function($q){
                $q->select('first_name','last_name');
            }
        ]
        );
    }

    public function scopeFilters($query, array $data)
    {
        return $query;
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function mentions()
    {
        return $this->belongsToMany(User::class, 'user_mentions','comment_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
