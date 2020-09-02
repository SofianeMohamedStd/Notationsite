<?php 

use App\Entites\User;

class UserEntiteTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $user = new User();
        $name ='mohammed';
        $this->assertTrue($user->verifusername($name));

    }
}