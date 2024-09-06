<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use App\Models\KtgMateriModel;

/**

 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * 
     */
    protected $model = KtgMateriModel::class;
    public function definition(): array
    {
        return [
            'nama_ktg' => $this->faker->words($this->faker->numberBetween(1, 2), true)
        ];
    }
}
