<?php

namespace App\Controller;



class HomeController extends AppController {



    public function index() {
        
       
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
