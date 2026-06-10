<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicPostTest extends TestCase
{
    public function test_home_redirects_to_posts(): void
    {
        $this->get('/')
            ->assertRedirect(route('posts.index'));
    }
}
