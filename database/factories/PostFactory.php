<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->unique()->slug(),
            'excerpt' => $this->faker->text(200), // Genera un resumen breve para el post
            'content' => $this->faker->text(3000), // Genera un contenido más largo para el post
            'user_id' => 1, // Asigna el ID del usuario que deseas, por ejemplo, el primer usuario creado
            'category_id' => Category::all()->random()->id, // Asigna una categoría aleatoria existente
            'is_published' => true, // Marca el post como publicado
            'published_at' => now(), // Asigna la fecha actual para la publicación
        ];
    }
}
