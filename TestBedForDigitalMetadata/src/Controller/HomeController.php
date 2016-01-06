<?php

namespace App\Controller;



class HomeController extends AppController {



    public function index() {
        
       $user = $this->Auth->user();
        
            if($user == null)
            {
                return $this->redirect(["controller" => "Home","action" => "login"]);
            }
        
        
    }
    public function start() {        
       
        return $this->redirect(["controller" => "Start"]);        
        
    }
    
    public function login()
    {
        $user = $this->Auth->user();
        
        if($user != null)
        {
            return $this->redirect(["controller" => "Admin"]);
        }
        
        $error = false;
        
        if($this->request->is("post"))
        {
            $user = $this->Auth->identify();
            
            if($user)
            {
                $this->Auth->setUser($user);
                
                $authUser = $this->Auth->user();
                
                if($authUser["role"] == 1)
                {
                    return $this->redirect(["controller" => "Admin"]);
                }
                else
                {
                    return $this->redirect(["controller" => "User"]);
                }
            }
            else
            {
                $error = true;
            }
        }

        $this->set("error",$error);
    }

}
