<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		$randomId = $this->faker->randomElements(str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 17);
		$randomId2 = $this->faker->randomElements(str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 17);
		$randomIdPayer = $this->faker->randomElements(str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'), 13);
		$surname = $this->faker->lastName();
		$givenName = $this->faker->firstName();
		$randomStatus = rand(0,20);
		switch($randomStatus) {
			case(0) : $status = 'FAILED'; break;
			case(1) : $status = 'CREATED'; break;
			//case($randomStatus > 15) : $status = 'SHIPPED'; break;
			default : $status = 'COMPLETED'; break;
		}

        return [
			'id' => $this->faker->randomNumber(9),
            'order_id' => $randomId,
            'transaction_id' => $randomId2,
            'payer_id' => $randomIdPayer,
			'surname' => $surname,
			'given_name' => $givenName,
			'full_name' => $givenName.' '.$surname,
			'phone' => null,
			'email_address' => $this->faker->email(),
			'address_line_1' => $this->faker->streetAddress(),
			'address_line_2' => null,
			'admin_area_2' => $this->faker->state(),
			'admin_area_1' => $this->faker->city(),
			'postal_code' => $this->faker->postcode(),
			'country_code' => 'FR',
			'coupon_id' => null,
			'shipping_method' => 'La Poste',
			'shipping_price' => 8.95,
			'shipped_at' => null,
			'tracking_number' => null,
			'status' => $status,
			'pre_order' => $this->faker->numberBetween(0, 1),
			'read' => $this->faker->numberBetween(0, 1),
			'hidden' => 0,
        ];
    }
}
