<?php

namespace App\Controller;

class AdminController extends AppController {

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        
        $user = $this->Auth->user();
        
        if($user == null || $user["role"] != 1)
        {
            return $this->redirect(["controller" => "Home"]);
        }
    }
    
    public function index() {
        
        $deleteMessage = "";
        $addMessage = "";
        
        if($this->request->is("post"))
        {
            $action = $this->request->data("action");
            
            $usersTable = \Cake\ORM\TableRegistry::get("Users");
            
            if($action == "add")
            { 
                $username = $this->request->data("username");
                $password = $this->request->data("password");
                
                if($username != "" && $password != "")
                {
                    $user = $usersTable->newEntity();

                    $user->username = $username;
                    $user->password = $password;
                    $user->role = 0;

                    if($usersTable->save($user))
                    {
                        $addMessage = "User successfully added!";
                    }
                }
                else
                {
                    $addMessage = "Username and password can't be empty!";
                }
            }
            else if ($action == "delete")
            {
                $id = $this->request->data("id");
                
                $user = $usersTable->get($id);
                
                if($usersTable->delete($user))
                {
                    $deleteMessage = "User successfully deleted!";
                }

            }
        }
        
        
        $users = \Cake\ORM\TableRegistry::get("Users")->find()->where(["role" => 0])->toArray();
        
        $this->set("users",$users);
        $this->set("addMessage",$addMessage);
        $this->set("deleteMessage",$deleteMessage);
        
    }
    
    public function changePassword()
    {
        $addMessage = "";
        
        if($this->request->is("post"))
        {
            $oldPassword = $this->request->data("old-password");
            $newPassword = $this->request->data("new-password");
            
            $user = $this->Auth->user();
            
            $usersTable = \Cake\ORM\TableRegistry::get("Users");
            
            $userEntity = $usersTable->get($user["id"]);
            
            if((new \Cake\Auth\DefaultPasswordHasher)->check($oldPassword, $userEntity->password))
            {
                if($newPassword != "")
                {
                    $userEntity->password = $newPassword;
                    
                    if($usersTable->save($userEntity))
                    {
                        $addMessage = "Password changed!";
                    }
                    else
                    {
                        $addMessage = "An error has occured!";
                    }
                }
                else
                {
                    $addMessage = "New password can't be empty!";
                }
            }
            else
            {
                $addMessage = "Old password is incorrect!";
            }
        }
        
        $this->set("addMessage",$addMessage);
    }

}
