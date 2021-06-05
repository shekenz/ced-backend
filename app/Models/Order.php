<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

	protected $fillable = [
		'lastname',
		'firstname',
		'company',
		'phone',
		'email',
		'shipping-address-1',
		'shipping-address-2',
		'shipping-city',
		'shipping-postcode',
		'shipping-country',
		'invoice-address-1',
		'invoice-address-2',
		'invoice-city',
		'invoice-postcode',
		'invoice-country',
	];
}
