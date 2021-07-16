<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class OrdersMassController extends Controller
{
	public $globalConditions;

	public $validation = [
		'ids' => ['nullable', 'array'],
		'ids.*' => ['numeric']
	];

    public function csv(Request $request) {
		$data = $request->validate($this->validation);
		if(!empty($data)) {
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
		} else {
			return back();
		}
	}

	public function hide(Request $request) {
		$data = $request->validate($this->validation);
			if(!empty($data)) {
			$orders = Order::find($data['ids']);

			$orders->each(function($order) {
				$order->hidden = true;
				$order->save();
			});
		}

		return back();
	}

	public function unhide(Request $request) {
		$data = $request->validate($this->validation);
		if(!empty($data)) {
			$orders = Order::find($data['ids']);

			$orders->each(function($order) {
				$order->hidden = false;
				$order->save();
			});
		}

		return redirect()->route('orders');
	}

	public function get(Request $request, string $method, string $from, string $end, string $visibility, $data = null) {
		if($request->wantsJson()) {
			$this->globalConditions = [
				['created_at', '>=', $from],
				['created_at', '<=', Carbon::create($end)->addDay()],
				['hidden', ($visibility !== 'false') ? true : false],
			];

			switch($method) {
				case 'all' : return $this->all(); break;
				case 'status' : return $this->status($data); break;
				default : return response()->json()->setStatusCode(400, '"'.$method.'" method not supported');
			}
		} else {
			return abort(404);
		}
	}

	public function all() {
		return Order::with('books')->where($this->globalConditions)->orderBy('created_at', 'DESC')->get();
	}

	public function status($data) {
		if($data) {
			return Order::with('books')->orderBy('created_at', 'DESC')->where('status', $data)->get();
		} else {
			return $this->all();
		}
	}
}