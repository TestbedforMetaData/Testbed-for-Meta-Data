<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;

class AdminController extends AppController {

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        
        $user = $this->Auth->user();
        
        if($user == null)
        {
            return $this->redirect(["controller" => "Home","action" => "login"]);
        }
    }
    
    public function user() {
        
        $authRole = $this->Auth->user()["role"];
        
        if($authRole != 1)
        {
            return $this->redirect(["controller" => "Home"]);
        }
        
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
        
        $adminTexts = TableRegistry::get("admin_texts");
        
       if($this->request->is("post"))
       {
           $text = $this->request->data("instruction-text");
           
           $newText = $adminTexts->find()->where(["name" => "instructions"])->first();
           
           $newText->text = $text;
           
           $adminTexts->save($newText);
       }
        
        
        $instructions = $adminTexts->find()->where(["name" => "instructions"])->first()->text;
            
        
        $this->set("instructions",$instructions);
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
               $this->loadComponent("Update");
               
               $name = $this->request->data("question-name");
               $text = $this->request->data("question-text");
               $type = $this->request->data("question-type");
               
               $optionsTable = TableRegistry::get("options");
               
               $question = $questions->get($id);
               
               $questionOptions = $question->options;
               
               $question->name = $name;
               $question->text = $text;
               $question->type_id = $type;
               

               $options = array();
               
               $order = 1;
               
               foreach($this->request->data as $key => $value)
               {
                   
                   
                   if (strpos($key,"option-") !== false) 
                   {
                       $index = str_replace("option-", "", $key);
                       
                       $optionId = $this->request->data("id-".$index);
                       
                       $obj = new \stdClass();
                       
                       $obj->id = $optionId;
                       $obj->visibleOrder = $order++;
                       $obj->text = $value;
                       
                       array_push($options, $obj);
                   }
               }
               
               $checkAddRemove = $this->Update->checkUpdate($options,$questionOptions);
               
               if($checkAddRemove)
               {
                   foreach($questionOptions as $option)
                   {
                       $newOption = null;
                       
                       foreach($options as $item)
                       {
                           if($item->id == $option->id)
                           {
                               $newOption = $item;
                           }
                       }
                       
                       $option->text = $newOption->text;
                       $option->visible_order = $newOption->visibleOrder;
                       
                       $optionsTable->save($option);
                   }
               }
               else
               {
                   foreach($questionOptions as $option)
                   {
                       $newOption = null;
                       
                       foreach($options as $item)
                       {
                           if($item->id == $option->id)
                           {
                               $newOption = $item;
                           }
                       }
                       
                       if($newOption != null)
                       {
                            $option->text = $newOption->text;
                            $option->visible_order = $newOption->visibleOrder;

                            $optionsTable->save($option);
                       }
                       else
                       {
                           $optionsTable->delete($option);
                       }
                   }
                   
                   foreach($options as $item)
                   {
                       if($item->id == -1)
                       {
                            $addOption = $optionsTable->newEntity();

                            $addOption->visible_order = $item->visibleOrder;
                            $addOption->text = $item->text;
                            $addOption->question_id = $question->id;
                            
                            $optionsTable->save($addOption);
                       }
                   }
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
        
       $this->loadComponent("Check");
        
       $added = false; 
       $message = "";
        
       $questions = TableRegistry::get("questions");
       $documents = TableRegistry::get("uploads");
       $compilations = TableRegistry::get("compilations");
       $compilationParts = TableRegistry::get("CompilationParts");
      
       $partArray = array();
       
       $compilationsList = array();
       
       foreach ($compilations->find() as $item)
       {
           if($this->Check->checkCompilation($item))
           {
               array_push($compilationsList, $item);
           }
       }
       
       if($this->request->is("post"))
       {
           $action = $this->request->data("action");
           
           if($action == "add")
           {
               foreach($this->request->data as $key => $value)
                   {
                       if (strpos($key,"document-") !== false && $value != -1) 
                       {
                            $obj = new \stdClass();
                            
                            $obj->type = "Document";
                            $obj->id = $value;
                            
                            array_push($partArray, $obj);
                       }
                       else if (strpos($key,"question-") !== false && $value != -1) 
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
               
               $addCompilation->url_key = md5(uniqid());
               
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
               $this->loadComponent("Update");
               
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

               
                $newParts = array();
               
                $order = 1;
                   
                foreach($this->request->data as $key => $value)
                {
                    if (strpos($key,"document-") !== false && strpos($key,"document-id-") === false) 
                    {
                        $index = str_replace("document-", "", $key);
                         
                        $mainId = $this->request->data("document-id-".$index);
                            
                        $obj = new \stdClass();
                            
                        $obj->type = "Document";
                        $obj->id = $mainId;
                        $obj->partId = $value;
                        $obj->visibleOrder = $order++;
                            
                        array_push($newParts, $obj);
                    }
                    else if (strpos($key,"question-") !== false && strpos($key,"question-id-") === false) 
                    {
                        $index = str_replace("question-", "", $key);
                           
                        $mainId = $this->request->data("question-id-".$index);
                           
                        $obj = new \stdClass();
                            
                        $obj->type = "Question";
                        $obj->id = $mainId;
                        $obj->partId = $value;
                        $obj->visibleOrder = $order++;
                            
                        array_push($newParts, $obj);
                    }
                }
                
                $checkAddRemove = $this->Update->checkUpdate($newParts,$parts);
               
                if($checkAddRemove)
               {
                   foreach($parts as $part)
                   {
                       $newPart = null;
                       
                       foreach($newParts as $item)
                       {
                           if($item->id == $part->id)
                           {
                               $newPart = $item;
                           }
                       }

                       $part->visible_order = $newPart->visibleOrder;
                       
                       $compilationParts->save($part);
                   }
               }
               else
               {
                   foreach($parts as $part)
                   {
                       $newPart = null;
                       
                       foreach($newParts as $item)
                       {
                           if($item->id == $part->id)
                           {
                               $newPart = $item;
                           }
                       }
                       
                       if($newPart != null)
                       {
                            $part->visible_order = $newPart->visibleOrder;
                       
                            $compilationParts->save($part);
                       }
                       else
                       {
                           $compilationParts->delete($part);
                       }
                   }
                   
                   foreach($newParts as $item)
                   {
                       if($item->id == -1)
                       {
                            $addPart = $compilationParts->newEntity();

                            $addPart->visible_order = $item->visibleOrder;
                            $addPart->compilation_id = $compilation->id;
                            $addPart->type = $item->type;
                            $addPart->part_id = $item->partId;
                            
                            $compilationParts->save($addPart);
                       }
                   }
               }
               
                $compilations->save($compilation);
                
                $message = "Compilation is updated successfully";

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
           
           $currentUrl = \Cake\Routing\Router::url(["controller" => "admin","action" => "index"],true);
           
           $domain = explode("admin", $currentUrl)[0];
           
           $keyUrl = $domain."start/compilation/".$compilation->url_key;
           
           $this->set("url",$keyUrl);
       }
       
       
       $this->set("questions",$questions->find());
       $this->set("documents",$documents->find());
       $this->set("compilations",$compilationsList);

      
       $this->set("id",$id);
       $this->set("added",$added);
       $this->set("message",$message);
    }




    public function answers($id = null) {
        
        $this->loadComponent("Check");
        
        $subjects = TableRegistry::get("Subjects");
        $answers = TableRegistry::get("Answers");
        $compilations = TableRegistry::get("Compilations");
        $compilationParts = TableRegistry::get("CompilationParts");
        $questions = TableRegistry::get("Questions");
        $options = TableRegistry::get("Options");
        $multipleAnswers = TableRegistry::get("MultipleAnswers");
        
        $subjectsList = array();
        
        $excelTable = new \stdClass();
        $excelTable->questions = array();
        $excelTable->subjects = array();
        $excelTable->compName = "";
       
        foreach ($subjects->find() as $item)
        {
            if($this->Check->checkSubject($item))
            {
                array_push($subjectsList, $item);
            }
        }
        
        $displayAnswers = array();
        
        $compilation = null;
        
        $subjectName = "";
        
        if($id != null)
        {
        $subjectAnswers = $answers->find()->where(["subject_id" => $id])->order("visible_order")->toArray(); 
        
        $compId = $subjects->get($id)->comp_id;
        
        $subjectName = $subjects->get($id)->name;
        
        if($compId != null && $compId != 0)
        {
            $compilation = $compilations->get($compId);
            
            $excelTable->compName = $compilation->name;
            
            $compSubjects = $subjects->find()->where(["comp_id" => $compId])->toArray();
            
            $compParts = $compilationParts->find()->where(["compilation_id" => $compId])->order("visible_order")->toArray();
            
            foreach($compParts as $compPart)
            {
                if($compPart->type === "Question")
                {
                    $q = new \stdClass();
                    
                    $q->id = $compPart->part_id;
                    
                    $qName = "";
                    
                    $qData = $questions->find()->where(["id" => $q->id])->toArray();
                    
                    if(!empty($qData))
                    {
                        $qName = $qData[0]->name;
                    }
                    
                    $q->name = $qName;
                    
                    array_push($excelTable->questions, $q);
                }
            }
            
            foreach($compSubjects as $compSubject)
            {
                $s = new \stdClass();
                
                $s->name = $compSubject->name;
                
                $s->answers = array();
                
                foreach($excelTable->questions as $eq)
                {
                    $answerText = "";
                    
                    $subjectAnswer = $answers->find()->where(["subject_id" => $compSubject->id, "question_id" => $eq->id])->first();
                    
                    if($subjectAnswer != null)
                    {
                        if($subjectAnswer->answer_text != "")
                        {
                            $answerText = $subjectAnswer->answer_text;
                        }
                        else if ($subjectAnswer->is_multiple == 0)
                        {
                            $answerOption = $options->find()->where(["id" => $subjectAnswer->answer_option_id])->first();

                            if($answerOption != null)
                            {
                                $answerText = $answerOption->text;
                            }
                        }
                        else
                        {
                            $answerParts = $multipleAnswers->find()->where(["answer_id" => $subjectAnswer->id])->toArray();

                            $optionArray = array();

                            foreach($answerParts as $ap)
                            {
                                $atext = "";
                                
                                $aOption = $options->find()->where(["id" => $ap->option_id])->first();

                                if($aOption != null)
                                {
                                    $atext = $aOption->text;
                                }
                                
                                array_push($optionArray, $atext);
                            }

                            $answerText = implode("<br/>", $optionArray);
                        }

                        array_push($s->answers,$answerText);
                    }
                }
                
                array_push($excelTable->subjects, $s);
            }
        }
        
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
        $this->set("subjects",$subjectsList);
        $this->set("answers",$displayAnswers);
        $this->set("compilation",$compilation);
        $this->set("subjectName",$subjectName);
        $this->set("excelTable",$excelTable);
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
