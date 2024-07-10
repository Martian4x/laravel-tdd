<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;


class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'slug'=> $this->faker->slug,
            'title' => $this->faker->title,
            'tagline' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl,
            'learnings' => ['Learn A', 'Learn B', 'Learn C'],
            'released_at' => null,
        ];
    }

    public function released(Carbon $date = null): self
    {
        return $this->state(
            fn($attributes) => ['released_at'=>$date??Carbon::now()]
        );
    }
}
