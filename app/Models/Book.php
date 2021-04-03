<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

	protected $fillable = [
        'title',
        'author',
        'width',
		'height',
		'cover',
		'pages',
		'edition',
		'price',
		'description',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
