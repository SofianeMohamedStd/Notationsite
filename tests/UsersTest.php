<?php
namespace Unity\tests;
use App\Entites\User;
use PHPUnit\Framework\TestCase;



class UsersTest extends TestCase
{
    public function testNameUserWithoutEspaceANDcaractere()
    {
        $user = new User();
        $name ='mohamedsofiane';
        $this->assertTrue($user->verifusername($name));
    }

    public function testNameUserWithEspaceANDcaractere()
    {
        $user = new User();
        $name = 'sofiane mohamed?';
        $this->assertFalse($user->verifusername($name));
    }
    
    public function testEmailCorrect()
    {
        $user = new User();
        $mail = 'mail@exemple.com';
        $this->assertTrue($user->verifEmail($mail));
    }

    public function testEmailIncorrect()
    {
        $user = new User();
        $mail = 'mailexemple.com';
        $this->assertFalse($user->verifEmail($mail));
    }

    public function testPasswordFormeNotCorrect(){
        $user = new User();
        $pass = "123456";
        $this->assertFalse($user->verifPassword($pass));
    }

    public function testPasswordFormeIfCorrect(){
        $user = new User();
        $pass = "123456789?";
        $this->assertTrue($user->verifPassword($pass));
    }

}