<?php
namespace App;

use PHPUnit\Framework\TestCase;
use App\Controllers\UsersController;


class UsersControllerTest extends TestCase 

{
   
    public function testAssertsMethodClassUsersController()
    {
        $this->user = new UsersController();
        $this->assertInstanceOf(UsersController::class, $this->user);
        $this->assertTrue(method_exists ($this->user,  'connexion' ));
        $this->assertTrue(method_exists ($this->user, 'register'));
        $this->assertTrue(method_exists ($this->user, 'logout'));

    }

}