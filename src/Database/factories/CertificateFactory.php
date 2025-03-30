<?php

namespace Eren\Lms\Database\Factories;

use Eren\Lms\Models\Course;
use Eren\Lms\Models\User;
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
            'user_id' => User::factory()->create()->id,
            'course_id' => Course::factory()->create(['status' => Course::PUBLISHED_STATUS])->id,
            "created_at" => dbDate(now()),
            "updated_at" => dbDate(now())
        ];
    }
}
