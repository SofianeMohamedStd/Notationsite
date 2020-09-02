<?php
namespace Unity\tests;

use PHPUnit\Framework\TestCase;
use App\Controllers\OeuvresController;



class OeuvreControllerTest extends TestCase 

{
   

    public function testAssertsMethodClassOeuvreController()
    {
        $this->oeuvre = new OeuvresController();
        $this->assertInstanceOf(OeuvresController::class, $this->oeuvre);
        $this->assertTrue(method_exists ($this->oeuvre,  'showAllOeuvres' ));
        $this->assertTrue(method_exists ($this->oeuvre, 'genre'));
        $this->assertTrue(method_exists ($this->oeuvre, 'showOeuvre'));

    }

}