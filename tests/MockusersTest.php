<?php
namespace App;
use App\Models\Users;
use PHPUnit\Framework\TestCase;



class MockusersTest extends TestCase 
{
    public function testpseudoExist()
    {
        $user='sofiane';
         $doublure = $this->getMockBuilder(Users::class) 
                          ->disableOriginalConstructor()
                          ->getMock();

         $doublure->expects($this->once()) 
              ->method('checkLogin')
              ->will($this->returnValue(false)) ;

         $this->assertEquals(false, $doublure->checkLogin($user)) ;
    }
}