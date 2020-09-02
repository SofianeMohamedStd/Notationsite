<?php
namespace Unity\tests;

use App\Models\Comments;
use PHPUnit\Framework\TestCase;




class ModelCommentstest extends TestCase 

{
   

    public function testAssertsMethodClassCommentsModel()
    {
        $this->comment = new Comments();
        $this->assertInstanceOf(Comments::class, $this->comment);
        $this->assertTrue(method_exists ($this->comment,  'getAllComments' ));
        $this->assertTrue(method_exists ($this->comment, 'addComment'));
        $this->assertTrue(method_exists ($this->comment, 'addUsersComments'));
        $this->assertTrue(method_exists ($this->comment, 'addOeuvreComments'));
        $this->assertTrue(method_exists ($this->comment, 'addObjetComments'));
        $this->assertTrue(method_exists ($this->comment, 'linkCommentByOeuvre'));
        $this->assertTrue(method_exists ($this->comment, 'linkCommentByObjet'));


    }

}