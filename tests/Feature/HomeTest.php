<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_home(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_only_admin_can_access_menu_admin(): void
    {
        $user = User::factory()->create();
        $user = $user->addRole('admin');
        $response = $this->actingAs($user)
        ->withSession(['banned' => false])
        ->get('/product_admin');
        $response->assertStatus(200);

        $user2 = User::factory()->create();
        $user2 = $user2->addRole('member');
        $response = $this->actingAs($user2)
        ->withSession(['banned' => false])
        ->get('/product_admin');
        $response->assertStatus(302);
    }
}
