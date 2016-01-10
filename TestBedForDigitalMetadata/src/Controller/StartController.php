<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;

class StartController extends AppController {
	
	public function index() 
	{
            $user = $this->Auth->user();
        
            if($user == null)
            {
                return $this->redirect(["controller" => "Home","action" => "login"]);
            }
            
            $c = TableRegistry::get("compilations");
            $comp = $c->find()->where(["is_active" => 1])->order('rand()')->first();
            $this->redirect(['controller'=>'start','action'=>'compilation',$comp->url_key]);
		
	}
	
	public function compilation($key)
	{
                $compilations = TableRegistry::get("Compilations");
            
                $comp = $compilations->find()->where(["url_key" => $key])->first();
                
                if($comp == null)
                {
                    $user = $this->Auth->user();
        
                    if($user == null)
                    {
                        return $this->redirect(["controller" => "Home","action" => "login"]);
                    }
                    else
                    {
                        return $this->redirect(["controller" => "Start","action" => "index"]);
                    }
                }
                
                $id = $comp->id;
            
		$uploads = TableRegistry::get("uploads");
		$loadquestions = TableRegistry::get("questions");

		$cP = TableRegistry::get("CompilationParts");
                
		$parts = $cP->find()->where(["compilation_id" => $id])->order("visible_order")->toArray();
		
                $post = false;
                
                if($this->request->is("post"))
                {
                    $post = true;
                    
                    $success = true;
                    
                    $userName = $this->request->data("user-name");
                    
                    $subjects = TableRegistry::get("subjects");
                    
                    $subject = $subjects->newEntity();
                    
                    $subject->name = $userName;
                    
                    $subject->comp_id = $id;
                    
                    $answersTable = TableRegistry::get("answers");
                    
                    $multipleAnswers = TableRegistry::get("multiple_answers");
                    
                    $answers = array();
                    
                    foreach($this->request->data as $key => $value)
                    {
                        if (strpos($key,"question-") !== false) 
                        {
                            
                            
                            if (strpos($key,"text") !== false) 
                            {
                                $answer = new \stdClass();
                                
                                $answer->type = "text";
                                
                                $tmp = str_replace("question-", "", $key);
                                $tmp = str_replace("-text", "", $tmp);
                               
                                $answer->questionId = $tmp;
                                $answer->text = $value;
                                
                                array_push($answers, $answer);
                            }
                            else if (strpos($key,"option") !== false)
                            {
                                $tmp = str_replace("question-", "", $key);
                                $tmp = str_replace("-option", "", $tmp);
                                
                                $type = "checkbox";
                                $questionId = explode("-", $tmp)[0];
                                $optionId = explode("-", $tmp)[1];
                                
                                $isInArray = false;
                                
                                foreach ($answers as $item)
                                {
                                    if($item->questionId == $questionId)
                                    {
                                        $isInArray = $item;
                                    }
                                }
                                
                                if(!$isInArray)
                                {
                                    $answer = new \stdClass();
                                    
                                    $answer->type = $type;
                                    $answer->questionId = $questionId;
                                    $answer->options = array();
                                    array_push($answer->options,$optionId);
                                    
                                    array_push($answers, $answer);
                                }
                                else
                                {
                                    array_push($isInArray->options,$optionId);
                                }
                            }
                            else
                            {
                                $answer = new \stdClass();
                                
                                $answer->type = "radio";
                                
                                $tmp = str_replace("question-", "", $key);
                                
                                $answer->questionId = $tmp;
                                $answer->option = $value;
                                
                                array_push($answers, $answer);
                            }
                        }
                    }
                    
                    if($subjects->save($subject))
                    {
                        foreach($answers as $index => $answer)
                        {
                            $newAnswer = $answersTable->newEntity();

                            $newAnswer->question_id = $answer->questionId;

                            $newAnswer->subject_id = $subject->id;
                            $newAnswer->visible_order = $index + 1;

                            if($answer->type == "text")
                            {
                                $newAnswer->answer_text = $answer->text;
                                $newAnswer->answer_option_id = -1;
                                $newAnswer->is_multiple = 0;
                                
                                if(!$answersTable->save($newAnswer))
                                {
                                    $success = false;
                                }
                            }
                            else if ($answer->type == "checkbox")
                            {
                                $newAnswer->answer_text = "";
                                $newAnswer->answer_option_id = -1;
                                $newAnswer->is_multiple = 1; 

                                if($answersTable->save($newAnswer))
                                {
                                    foreach($answer->options as $option)
                                    {
                                        $answerOption = $multipleAnswers->newEntity();

                                        $answerOption->option_id = $option;
                                        $answerOption->answer_id = $newAnswer->id;

                                        $multipleAnswers->save($answerOption);
                                    }
                                }
                                else
                                {
                                    $success = false;
                                }
                                
                                
                            }
                            else if ($answer->type == "radio")
                            {
                                $newAnswer->answer_text = "";
                                $newAnswer->answer_option_id = $answer->option;
                                $newAnswer->is_multiple = 0; 
                                
                                if(!$answersTable->save($newAnswer))
                                {
                                    $success = false;
                                }
                            }

                            
                        }
                    }
                    else
                    {
                        $success = false;
                    }
                    
                    $this->set("success",$success);
                }
                else
                {
                    $components = array();

                    foreach($parts as $item)
                    {
                        $component = new \stdClass();

                        if($item->type == "Document")
                        {
                            $component->type = "Document";

                            $file = $uploads->get($item->part_id);

                            $component->fileName = $file->filename;

                            $component->title = $file->name;
                        }
                        else if ($item->type == "Question")
                        {
                            $component->type = "Question";

                            $question = $loadquestions->get($item->part_id);

                            $component->text = $question->text;

                            $component->questionType = $question->type;

                            $component->questionId = $question->id;

                            $component->hasOptions = false;

                            if($question->type_id == 2 || $question->type_id == 3)
                            {
                                $component->hasOptions = true;

                                $optionsList = $question->options;

                                $component->options = array();

                                foreach($optionsList as $optionItem)
                                {
                                    $option = new \stdClass();

                                    $option->text = $optionItem->text;

                                    $option->id = $optionItem->id;

                                    array_push($component->options,$option);
                                }
                            }

                            $component->title = $question->name;
                        }

                        array_push($components,$component);
                    }
                    
                    $instructions = TableRegistry::get("admin_texts")->find()->where(["name" => "instructions"])->first()->text;
                    
                    $this->set("instructions",$instructions);
                    $this->set("components",$components);
                }
                
                $this->set("post",$post);
		
	}
}
