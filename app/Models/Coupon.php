<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
	public $timestamps = false;

	protected $dates = [
        'starts_at',
        'expires_at'
    ];

	public $fillable = [
		'label',
		'value',
		'type',
		'quantity',
		'used',
		'created_at',
		'starts_at',
		'expires_at',
	];

	public function orders() {
		return $this->hasMany(Order::class);
	}
}
