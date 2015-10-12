<?php

namespace App\Controller;

class UserController extends AppController {

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        
        $user = $this->Auth->user();
        
        if($user == null)
        {
            return $this->redirect(["controller" => "Home"]);
        }
    }
    
    public function index() {
        
    }
    
    public function logout()
    {
        $this->Auth->logout();
        
        return $this->redirect(["controller" => "Home"]);
    }

}
