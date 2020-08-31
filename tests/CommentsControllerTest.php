<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\CommentsController;




class CommentsControllerTest extends TestCase 

{
    /*public function index(){
        $this->user = new UsersController();
      }*/
  

    public function testAssertsMethodClassCommentsController()
    {
        $this->comment = new CommentsController();
        $this->assertInstanceOf(CommentsController::class, $this->comment);
        $this->assertTrue(method_exists ($this->comment,  'index' ));
        $this->assertTrue(method_exists ($this->comment, 'commentairetemporaire'));
        $this->assertTrue(method_exists ($this->comment , 'addComment'));
        $this->assertTrue(method_exists ($this->comment , 'postAfterLogin'));

    }

}