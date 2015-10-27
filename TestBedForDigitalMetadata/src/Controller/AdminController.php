<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

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
    
    public function user() {
        
        $deleteMessage = "";
        $addMessage = "";
        
        if($this->request->is("post"))
        {
            $action = $this->request->data("action");
            
            $usersTable = TableRegistry::get("Users");
            
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
        
        
        $users = TableRegistry::get("Users")->find()->where(["role" => 0])->toArray();
        
        $this->set("users",$users);
        $this->set("addMessage",$addMessage);
        $this->set("deleteMessage",$deleteMessage);
        
    }
    
    
    public function index() {
        
       
        
    }
    
    
    public function documents($id = null) {
        
       $this->loadComponent('Upload');
        
       $message = "";
        
       if($this->request->is("post"))
	{
            $message = $this->Upload->processUpload();
	}
        
        $uploads = TableRegistry::get("uploads");
        
        if($id != null)
        {
            $document = $uploads->get($id);
            
            $this->set("document",$document);
        }
        
        $this->set("uploads",$uploads->find()->toArray());
	$this->set("message",$message);
        $this->set("id",$id);
        
    }
    
    
    public function questions($id = null) {
        
       $questions = TableRegistry::get("questions");
       
       $message = "";
       
       $post = false;
       $added = false;
       
       if($this->request->is("post"))
       {
           $post = true;
           
           $action = $this->request->data("action");
           
           if($action == "add")
           {
               $name = $this->request->data("question-name");
               $text = $this->request->data("question-text");
               $type = $this->request->data("question-type");
               
               $options = array();
               
               foreach($this->request->data as $key => $value)
               {
                   if (strpos($key,"option-") !== false) 
                   {
                       array_push($options, $value);
                   }
               }
               
               $addQuestion = $questions->newEntity();
               
               $addQuestion->name = $name;
               $addQuestion->text = $text;
               $addQuestion->type_id = $type;
               
               if($questions->save($addQuestion))
               {
                    if($type == 2 || $type == 3)
                    {
                        $optionsTable = TableRegistry::get("options");

                        foreach($options as $key => $item)
                        {
                            $addOption = $optionsTable->newEntity();

                            $addOption->text = $item;
                            $addOption->question_id = $addQuestion->id;
                            $addOption->visible_order = $key + 1;
                            
                            $optionsTable->save($addOption);
                        }
                    }
                    
                    $message = "Question is added successfully";
                    $added = true;
               }
               else
               {
                   $message = "An error occured while adding the question!";
               }
           }
       }

       if($id != null)
       {
           $question = $questions->get($id);

           $this->set("question",$question);
       }
       
       
       $this->set("questions",$questions->find());
       $this->set("message",$message);
       $this->set("id",$id);
       
       $this->set("post",$post);
       $this->set("added",$added);
        
    }
    
    public function compilations($id = null){
        
       $questions = TableRegistry::get("questions");
       $documents = TableRegistry::get("uploads");
       $compilations = TableRegistry::get("compilations");
       $compilationParts = TableRegistry::get("CompilationParts");
      
       $partArray = array();
       
       if($this->request->is("post"))
       {
           $action = $this->request->data("action");
           
           if($action == "add")
           {
               foreach($this->request->data as $key => $value)
                   {
                       if (strpos($key,"document-") !== false) 
                       {
                            $obj = new \stdClass();
                            
                            $obj->type = "Document";
                            $obj->id = $value;
                            
                            array_push($partArray, $obj);
                       }
                       else if (strpos($key,"question-") !== false) 
                       {
                            $obj = new \stdClass();
                            
                            $obj->type = "Question";
                            $obj->id = $value;
                            
                            array_push($partArray, $obj);
                       }
                   }
               
               
               $name = $this->request->data("compilation-name");
               
               $addCompilation = $compilations->newEntity();
               
               $addCompilation->name = $name;
               
               if($compilations->save($addCompilation))
               {
                   foreach ($partArray as $key => $item)
                   {
                       $compPart = $compilationParts->newEntity();
                       
                       $compPart->compilation_id = $addCompilation->id;
                       $compPart->part_id = $item->id;
                       $compPart->type = $item->type;
                       $compPart->visible_order = $key + 1;
                       
                       $compilationParts->save($compPart);
                   }
               }
           }
       }
       
       if($id != null)
       {
           $compilation = $compilations->get($id);
           
           $this->set("compilation",$compilation);
       }
       
       
       $this->set("questions",$questions->find());
       $this->set("documents",$documents->find());
       $this->set("compilations",$compilations->find());

      
       $this->set("id",$id);
        
    }




    public function answers() {
        
       
        
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
