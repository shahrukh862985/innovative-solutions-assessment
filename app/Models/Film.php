<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'release_date',
        'rating',
        'price',
        'country',
        'genre',
        'photo',
        'created_by',
    ];
    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        if ($this->photo != null) {
            return asset('/storage/' . $this->photo);
        }
        return asset('images/placeholder-image.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'film_id', 'id')->orderByDesc('id');
    }
}
