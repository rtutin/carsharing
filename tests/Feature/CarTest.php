<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\Car;

class CarTest extends TestCase
{
    use RefreshDatabase;

    public function test_my()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create(['user_id' => $user->id]);
        $login = $this->post('/api/login', ['email' => $user->email, 'password' => 'password'])->json();

        $response = $this->withHeaders(['Authorization' => $login['token_type'] . ' ' . $login['access_token']])
            ->get('/api/car/my');

        $response
            ->assertStatus(200)
            ->assertJson(['user_id' => $user->id]);
    }

    public function test_change()
    {
        $car = Car::factory()->create();
        $user = User::factory()->create();
        $admin = User::factory()->create(['name' => 'admin']);
        $login = $this->post('/api/login', ['email' => $admin->email, 'password' => 'password'])->json();

        $response = $this->withHeaders(['Authorization' => $login['token_type'] . ' ' . $login['access_token']])
            ->put('/api/car/change', [
                'car_id' => $car->id,
                'user_id' => $user->id
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(['info' => 'successfull change']);
    }

    public function test_cancel()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create(['user_id' => $user->id]);
        $login = $this->post('/api/login', ['email' => $user->email, 'password' => 'password'])->json();

        $response = $this->withHeaders(['Authorization' => $login['token_type'] . ' ' . $login['access_token']])
            ->put('/api/car/cancel');

        $response
            ->assertStatus(200)
            ->assertJson(['info' => 'car is cancelled']);
    }

    public function test_book()
    {
        $user = User::factory()->create();
        $car = Car::factory()->create();
        $login = $this->post('/api/login', ['email' => $user->email, 'password' => 'password'])->json();

        $response = $this->withHeaders(['Authorization' => $login['token_type'] . ' ' . $login['access_token']])
            ->put('/api/car/book', [
                'car_id' => $car->id
            ]);

        $response
            ->assertStatus(200)
            ->assertJson(['info' => 'car is booked']);
    }
}
