<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
			'title' => $this->faker->sentence(4),
			'author' => $this->faker->firstName().' '.$this->faker->lastName(),
			'user_id' => 1,
			'width' => rand(150, 300),
			'height' => rand(150, 300),
			'cover' => $this->faker->randomElement(['Souple', 'Flex', 'Rigide', 'Magazine']),
			'pages' => rand(20, 400),
			'copies' => rand(10,300),
			'quantity' => rand(10, 300),
			'pre_order' => 0,
			'year' => $this->faker->year(),
			'price' => round(rand(1000,10000)/100, 2),
			'description' => $this->faker->paragraph(10, true),
		];
    }
}
