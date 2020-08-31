<?php

namespace App\Entites;

class Oeuvre {

   
    public function verifusername($username){
        if($username == null)
        {
            return true;
        }
        
    }

    public function verifyear($year){
        if(strlen($year) == 4  && $year < 2020)
        {
            return true;
        }
        
    }


   
    

   
}