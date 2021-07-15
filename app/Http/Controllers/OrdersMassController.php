<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class OrdersMassController extends Controller
{
    public function csv(Request $request) {
		$data = $request->validate([
			'ids' => ['nullable', 'array'],
			'ids.*' => ['numeric']
		]);

		$orders = Order::find($data['ids']);

		$fileName = 'orders_'.Carbon::now()->toDateString().'.csv';

        $headers = array(
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename='.$fileName,
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0'
        );

        $columns = ['id','name', 'email', 'address_1', 'address_2', 'city', 'region', 'postcode', 'country', 'delivery', 'tracking'];

        $callback = function() use($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');
            foreach ($orders as $order) {
                fputcsv(
					$file,
					[
						$order->order_id,
						$order->full_name,
						$order->email_address,
						$order->address_line_1,
						$order->address_line_2,
						$order->admin_area_2,
						$order->admin_area_1,
						$order->postal_code,
						$order->country_code,
						$order->shipping_method,
						$order->tracking_url
					],
					';'
				);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
	}
}
