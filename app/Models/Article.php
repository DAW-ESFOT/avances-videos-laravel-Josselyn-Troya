<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    //use HasFactory;
    protected $fillable = ['title', 'body', 'category_id', 'image'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($article) {
            $article->user_id = Auth::id();
        });
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
