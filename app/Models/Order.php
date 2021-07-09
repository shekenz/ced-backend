<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

	protected $fillable = [
		'order_id',
		'transaction_id',
		'payer_id',
		'surname',
		'given_name',
		'full_name',
		'phone',
		'email_address',
		'address_line_1',
		'address_line_2',
		'admin_area_2',
		'admin_area_1',
		'postal_code',
		'country_code',
		'shipping_method',
		'shipping_price',
		'shipped_at',
		'tracking_number',
		'status',
		'pre_order',
		'read',
	];

	public function books() {
		return $this->belongsToMany(Book::class)->withPivot('quantity');
	}

	public function shippingMethods() {
		$this->belongsTo(ShippingMethod::class, 'shipping_option_id');
	}
}
