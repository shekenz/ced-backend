<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'lang',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function media() {
        return $this->hasMany(Medium::class);
    }
}
