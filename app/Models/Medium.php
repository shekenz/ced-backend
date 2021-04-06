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
		'filehash',
		'extension',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
	
	// Media relation with books
	public function books() {
		return $this->belongsToMany(Book::class, 'book_medium', 'medium_id', 'book_id');
	}

	// Accessor
	public function getFilenameAttribute()
    {
        return $this->attributes['filehash'].'.'.$this->attributes['extension'];
    }

	public function getThumbAttribute()
    {
        return $this->attributes['filehash'].'_thumb.'.$this->attributes['extension'];
    }

	public function getThumb2xAttribute()
    {
        return $this->attributes['filehash'].'_thumb@2x.'.$this->attributes['extension'];
    }

	public function getHdAttribute()
    {
        return $this->attributes['filehash'].'_hd.'.$this->attributes['extension'];
    }

	public function getLgAttribute()
    {
        return $this->attributes['filehash'].'_lg.'.$this->attributes['extension'];
    }

	public function getMdAttribute()
    {
        return $this->attributes['filehash'].'_md.'.$this->attributes['extension'];
    }

	public function getSmAttribute()
    {
        return $this->attributes['filehash'].'_sm.'.$this->attributes['extension'];
    }
}
