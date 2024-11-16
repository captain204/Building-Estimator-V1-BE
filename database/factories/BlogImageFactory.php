<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\BlogImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogImageFactory extends Factory
{
    protected $model = BlogImage::class;

    public function definition()
    {
        return [
            'blog_id' => Blog::factory(),
            'image_url' => $this->faker->imageUrl(), 
            'caption' => $this->faker->sentence(),
        ];
    }
}
