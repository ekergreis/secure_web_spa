<?php
// [TESTS] Tests unitaires de l'API login
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCanLogin()
    {
        $user = factory(User::class)->create(['password' => bcrypt('test')]);
        $reponse = $this->json('post', 'api/login', ['email' => $user->email, 'password' => 'test']);
        $reponse->assertStatus(200);
        $reponse->assertJsonStructure(['access_token', 'token_type', 'expires_at', 'group']);
    }
    public function testBadLoginPassword()
    {
        $user = factory(User::class)->create(['password' => bcrypt('test')]);
        $reponse = $this->json('post', 'api/login', ['email' => $user->email, 'password' => 'bad']);
        $reponse->assertStatus(401);
    }
    public function testBadLoginUser()
    {
        $reponse = $this->json('post', 'api/login', ['email' => 'test@testeur.com', 'password' => 'bad']);
        $reponse->assertStatus(401);
    }
    public function testBadParamFormat()
    {
        $reponse = $this->json('post', 'api/login', ['email' => 'test.fr', 'password' => 'bad']);
        $reponse->assertStatus(422);
    }
}
