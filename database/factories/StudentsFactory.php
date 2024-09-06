<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MuridModel;
use Faker\Factory as Faker;

/**

 */
class StudentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    protected $model = MuridModel::class;
    public function definition(): array
    {
        $faker= Faker::create('id_ID');
        return [
            'nama'=>$faker->name(),
            'no_tlp'=>$faker->unique()->phoneNumber(),
            'alamat'=>$faker->address()
        ];
    }
}
