<?php
namespace Unity\tests;
use App\Entites\Oeuvre;
use PHPUnit\Framework\TestCase;


class OeuvreTest extends TestCase
{
    
    public function testNameOeuvreExist()
    {
        $user = new Oeuvre();
        $name ='';
        $this->assertTrue($user->verifusername($name));
    }
    public function testvalidyear(){
        $user = new Oeuvre();
        $year = "2000";
        $this->assertTrue($user->verifyear($year));
    }
}