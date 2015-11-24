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
           $action = $this->request->data("action");
           
           $name = $this->request->data("document-name");
           
           if($action == "add")
           {
               $message = $this->Upload->processUpload($name);
           }
           else if ($action == "delete")
           {
               $message = $this->Upload->deleteDocument($id);
               
               return $this->redirect(["action" => "documents"]);
           }
           else if ($action == "update")
           {
               $message = $this->Upload->updateDocument($id,$name);
           }
           
           
            
	}
        
        $uploads = TableRegistry::get("uploads");
        
        if($id != null)
        {
            $document = $uploads->get($id);
            
            $this->set("document",$document);
            $this->set("active",$document->active);
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
           else if ($action == "update")
           {
               $name = $this->request->data("question-name");
               $text = $this->request->data("question-text");
               $type = $this->request->data("question-type");
               
               $optionsTable = TableRegistry::get("options");
               
               $question = $questions->get($id);
               
               $questionOptions = $question->options;
               
               $question->name = $name;
               $question->text = $text;
               $question->type_id = $type;
               
               foreach($questionOptions as $item)
               {
                   $optionsTable->delete($item);
               }
               
               $options = array();
               
               foreach($this->request->data as $key => $value)
               {
                   if (strpos($key,"option-") !== false) 
                   {
                       array_push($options, $value);
                   }
               }
               
               foreach($options as $key => $item)
                {
                    $addOption = $optionsTable->newEntity();

                    $addOption->text = $item;
                    $addOption->question_id = $question->id;
                    $addOption->visible_order = $key + 1;
                            
                    $optionsTable->save($addOption);
                }
                        
                $questions->save($question);
                
                $message = "Question is updated successfully";

           }
           else if ($action == "delete")
           {
               $question = $questions->get($id);
               
               if($question->type_id != 1)
               {
                   $questionOptions = $question->options;
                   
                   $optionsTable = TableRegistry::get("options");
                   
                   foreach($questionOptions as $item)
                   {
                       $optionsTable->delete($item);
                   }
               }
               
               $questions->delete($question);
               
               return $this->redirect(["action" => "questions"]);
           }
       }

       if($id != null)
       {
           $question = $questions->get($id);

           $this->set("question",$question);
           $this->set("active",$question->active);
       }
       
       
       $this->set("questions",$questions->find());
       $this->set("message",$message);
       $this->set("id",$id);
       
       $this->set("post",$post);
       $this->set("added",$added);
        
    }
    
    public function compilations($id = null){
        
       $added = false; 
       $message = "";
        
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
                   
                   $message = "Compilation is added successfully";
                    $added = true;
               }
               else
               {
                   $message = "An error occured while adding the compilation!";
               }
           }
           else if ($action == "update")
           {
               $name = $this->request->data("compilation-name");
               
               $compActive = $this->request->data("compilation-active");
               
               $active = 0;
               
               if($compActive == "on")
               {
                   $active = 1;
               }
               
               $compilation = $compilations->get($id);
               
               $questionOptions = $question->options;
               
               $compilation->name = $name;
               $compilation->is_active = $active;

               $parts = $compilationParts->find()->where(["compilation_id" => $compilation->id])->order("visible_order")->toArray();

                   foreach($parts as $item)
                   {
                       $compilationParts->delete($item);
                   }
                   
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
                   
                   if($compilations->save($compilation))
               {
                   foreach ($partArray as $key => $item)
                   {
                       $compPart = $compilationParts->newEntity();
                       
                       $compPart->compilation_id = $compilation->id;
                       $compPart->part_id = $item->id;
                       $compPart->type = $item->type;
                       $compPart->visible_order = $key + 1;
                       
                       $compilationParts->save($compPart);
                   }
                   
                   $message = "Compilation is updated successfully";
               }
               
              
                        
               
           }
           else if ($action == "delete")
           {
               $compilation = $compilations->get($id);

                   $parts = $compilationParts->find()->where(["compilation_id" => $compilation->id])->order("visible_order")->toArray();

                   foreach($parts as $item)
                   {
                       $compilationParts->delete($item);
                   }
               
               
               $compilations->delete($compilation);
               
               return $this->redirect(["action" => "compilations"]);
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
       $this->set("added",$added);
       $this->set("message",$message);
    }




    public function answers($id = null) {
        
        $subjects = TableRegistry::get("Subjects");
        $answers = TableRegistry::get("Answers");
        
        $displayAnswers = array();
        
        if($id != null)
        {
        $subjectAnswers = $answers->find()->where(["subject_id" => $id])->order("visible_order")->toArray(); 
        
        foreach($subjectAnswers as $item)
        {
            $part = new \stdClass();
            
            $question = TableRegistry::get("Questions")->get($item->question_id);
            
            $part->text = $question->text;
            $part->order = $item->visible_order;
            
            if($item->answer_text != "")
            {
                $part->type = "text";
                $part->answer_text = $item->answer_text;
            }
            else if($item->is_multiple == 0)
            {
                $part->type = "radio";
                $part->options = array();
                
                foreach($question->options as $optionItem)
                {
                    $option = new \stdClass();
                    
                    $option->text = $optionItem->text;
                    
                    if($optionItem->id == $item->answer_option_id)
                    {
                        $option->checked = true;
                    }
                    else
                    {
                        $option->checked = false;
                    }
                    
                    array_push($part->options,$option);
                }
            }
            else
            {
                $answerMultiple = TableRegistry::get("Multiple_Answers")->find()->where(["answer_id" => $item->id])->toArray();
                
                $answerOptions = array();
                
                foreach($answerMultiple as $i)
                {
                    array_push($answerOptions, $i->option_id);
                }
                
                $part->type = "checkbox";
                
                $part->options = array();
                
                foreach($question->options as $optionItem)
                {
                    $option = new \stdClass();
                    
                    $option->text = $optionItem->text;
                    
                    if(in_array($optionItem->id, $answerOptions))
                    {
                        $option->checked = true;
                    }
                    else
                    {
                        $option->checked = false;
                    }
                    
                    array_push($part->options,$option);
                }
            }
            
            array_push($displayAnswers, $part);
        }
        }
        
        
        $this->set("id",$id);
        $this->set("subjects",$subjects->find());
        $this->set("answers",$displayAnswers);
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
