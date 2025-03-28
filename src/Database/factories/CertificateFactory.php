<?php

namespace Eren\Lms\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CertificateFactory extends Factory
{
    protected $model = \Eren\Lms\Models\Certificate::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "code" => $this->faker->unique()->word(),
            "download_count" => $this->faker->randomDigit(),
            'user_id' => \App\Models\User::factory()->create()->id,
            'course_id' => \App\Models\Course::factory()->create(['status' => config("setting.course_status.published")])->id,
            "created_at" => dbDate(now()),
            "updated_at" => dbDate(now())
        ];
    }
}
