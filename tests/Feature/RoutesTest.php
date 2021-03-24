<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * Redirects to the home page
     *
     * @return void
     */
    public function testHome()
    {
        $response = $this->get('/');
        $response->assertStatus(302);
    }

    /**
     * Go to the show/home page for an user
     */
    public function testShow()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/home');

        $response->assertStatus(200);
    }

    /**
     * Go to the edit page
     */
    public function testEdit()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/edit');

        $response->assertStatus(200);
    }

    /**
     * Go to the role edit page for an user
     */
    public function testEditUserRole()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/editUserRole/4');

        $response->assertStatus(200);
    }

    /**
     * Non existing user
     */
    public function testEditUserRoleNotFound()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/editUserRole/400');

        $response->assertStatus(500);
    }

    /**
     * Update user info successfully
     */
    public function testUpdateUserInfo()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/update', [
                'name'      => 'Emily',
                'gender'    => 'F',
                'address'   => '8 Hall Road',
                'postcode'  => 'GH7 8UH',
                'county'    => 'London',
                'phone'     => '345678909',
                'about_me'  => 'blablabla blbalbal!'
            ]);

        $response->assertStatus(200);
    }

    /**
     * Update user info missing required field
     */
    public function testUpdateUserInfoMissingField()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/update', [
                'gender'    => 'F',
                'address'   => '8 Hall Road',
                'postcode'  => 'GH7 8UH',
                'county'    => 'London',
                'phone'     => '345678909',
                'about_me'  => 'blablabla blbalbal!'
            ]);

        $response->assertJson([
            'status' => 'error'
        ]);
    }

    /**
     * Update user roles for logged user successfully
     */
    public function testUpdateUserRole()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/updateUserRole', [
                'roles' => ['2', '4']
            ]);

        $response->assertStatus(200);
    }

    /**
     * Update user roles with missing required field
     */
    public function testUpdateUserRoleMissingRequired()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post('/updateUserRole', []);

        $response->assertJson([
            'status' => 'error'
        ]);
    }

}
