<?php
// [TESTS] Tests unitaires de l'API menu
namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class MenuTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testMenuBadAuth()
    {
        $reponse = $this->json('get', 'api/menu');
        $reponse->assertStatus(401);
    }
    public function testCanMenuAdmin()
    {
        $user = factory(User::class)->create(['password' => bcrypt('test'), 'role' => 'admin']);

        $reponse = $this->actingAs($user, 'api')->json('get', 'api/menu');
        $reponse->assertStatus(200);
        $reponse->assertJsonStructure(['user']);
        $this->assertStringContainsStringIgnoringCase('info user',$reponse->getContent());
        $this->assertStringContainsStringIgnoringCase('page 2',$reponse->getContent());
        $this->assertStringNotContainsStringIgnoringCase('page 1',$reponse->getContent());
    }
    public function testCanMenuStandard()
    {
        $user = factory(User::class)->create(['password' => bcrypt('test'), 'role' => 'standard']);

        $reponse = $this->actingAs($user, 'api')->json('get', 'api/menu');
        $reponse->assertStatus(200);
        $reponse->assertJsonStructure(['user']);
        $this->assertStringContainsStringIgnoringCase('page 1',$reponse->getContent());
        $this->assertStringContainsStringIgnoringCase('page 2',$reponse->getContent());
        $this->assertStringNotContainsStringIgnoringCase('info user',$reponse->getContent());
    }
}
