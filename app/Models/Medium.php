<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medium extends Model
{
    use HasFactory;

    // We are only using the created_at timestamp here
    const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'filename',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

	// Media relation with books
	public function books() {
		return $this->belongsToMany(Book::class, 'book_medium', 'medium_id', 'book_id');
	}
}
