<?php

namespace Database\Seeders;

use Database\Factories\OrderFactory;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Book;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Order::factory()->count(50)->hasAttached(
			Book::factory()->count(1),
			['quantity' => 1]
		)->create();
    }
}
