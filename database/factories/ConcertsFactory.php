<?php

namespace Database\Factories;

use App\Models\Concerts;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConcertsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Concerts::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'artist_name' => $this->faker->name,
            'locatie' => $this->faker->address,
            'concert_date' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = '+2 years', $timezone = null),
            'prijs' => $this->faker->numberBetween(5,10),
            'published' => true,
            'file_path' => '1621944960-summer concert.jpg'
        ];
    }
}
