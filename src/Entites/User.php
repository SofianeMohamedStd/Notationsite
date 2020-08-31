<?php

namespace App\Entites;


class User {


    
    public function verifusername($username){
        if(strpos($username, " ") == false && preg_match(",^[a-zA-Z0-9\ [\]._-]+$,", $username))
        {
            return True;
        }
        else {
            return false;
        }	
    }
  
    public function verifEmail($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
         {
               return True; 
            }else {
                return false;
            }
    }
  
    public function verifPassword($password){
        if(strlen($password) < 8 && preg_match(",^[a-zA-Z0-9\ [\]._-]+$,", $password)){
  
           return false; 
        }else {
        return True;
        }
     }
  
  
  
  

  
}