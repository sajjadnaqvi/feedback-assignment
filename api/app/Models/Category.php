<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Feedback;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    protected $fillable = [
        'name',
        'type'
    ];

    public function scopeListingInfo($query)
    {
        return $query;
    }

    public function scopeSingleInfo($query)
    {
        return $query;
    }

    public function scopeFilters($query, array $data)
    {
        $query->when((!empty($data["name"])), function ($q) use ($data) {
            $q->where('name', $data["name"]);
        });

        $query->when((!empty($data["type"])), function ($q) use ($data) {
            $q->where('type', $data["type"]);
        });
        return $query;
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class)->withTrashed();
    }
}
