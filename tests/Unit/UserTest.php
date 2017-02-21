<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */

    public function testHome()
    {
    

	    $this->visit('/')
	         ->seePageIs('/home');
    }

    public function testRegister()
    {
	    $this->visit('/register')
	         ->type('newperson','name')
	         ->type('something@gmail.com', 'email')
	         ->type('popoqwqw','password')
	         ->type('popoqwqw','password_confirmation')
	         ->press('Register')
	         ->seePageIs('/home');
    }

    public function testusersDatabase()
    {
    	// Make call to application...

        $this->seeInDatabase('users', ['email' => 'something@gmail.com','name'=>'newperson']);
    }

	public function testLogin()
    {
	    $this->visit('/login')
	         ->type('ami@hello.com', 'email')
	         ->type('asdfgh','password')
	         ->press('Login')
	         ->seePageIs('/home');
    }

	public function createNewPost()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
             ->withSession(['email' => 'ami@hello.com','password'=>'asdfgh'])
             ->visit('/home')
             ->click('Create New Post')
             ->seePageIs('/new-post');
    }

    
}
