<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{

     protected $model = Profile::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // En tests podés sobreescribir 'user_id' -> ['user_id' => $estu->id]
            'user_id'   => User::factory(),
            'nombre'    => $this->faker->firstName(),
            'apellido'  => $this->faker->lastName(),
            'dni'       => $this->faker->unique()->numerify('########'),
            'telefono'  => $this->faker->numerify('3704######'),
            'carrera'   => $this->faker->randomElement(['Tecnicatura en Programación','Ing. Sistemas', null]),
            'comision'  => $this->faker->randomElement(['A','B','C', null]),
            'foto_path' => null,
            'social_links' => [
                'instagram' => null,
                'facebook'  => null,
                'linkedin'  => null,
                'web'       => null,
            ],
        ];
    }
}
