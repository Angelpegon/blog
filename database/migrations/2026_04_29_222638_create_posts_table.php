<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')
                ->unique(); //Campo para la URL amigable del post

            $table->text('excerpt')
                ->nullable(); //Campo para un resumen breve del post
            $table->mediumText('content')
                ->nullable(); //Campo para el contenido completo del post

            $table->string('image_path')
                ->nullable(); //Campo para la imagen destacada del post, puede ser nulo
            
            $table->foreignId('user_id')
                ->constrained()//Relación con la tabla de usuarios, eliminando el post si se elimina el usuario
                ->onDelete('cascade'); 

            $table->foreignId('category_id')
                ->constrained()//Relación con la tabla de categorías, eliminando el post si se elimina la categoría
                ->onDelete('cascade');

            $table->boolean('is_published')
                ->default(false); //Campo para indicar si el post está publicado o no

            $table->timestamp('published_at')
                ->nullable(); //Campo para la fecha de publicación del post, puede ser nulo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
