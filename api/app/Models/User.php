<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

use  App\Models\Feedback;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = [
        "full_name",
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
        $query->when((!empty($data["search"])), function ($q) use ($data) {
            $q->where('name', 'LIKE', '%'.$data["name"].'%');
        });
        return $query;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function feedbacks ()
    {
        return $this->hasMany(Feedback::class)->withTrashed();
    }
}
