<?php


namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class CheckComponent extends Component {
 
    public function checkCompilation($compilation)
    {
        $compilations = TableRegistry::get("Compilations");
        $questions = TableRegistry::get("Questions");
        $compilationParts = TableRegistry::get("CompilationParts");
        $uploads = TableRegistry::get("Uploads");
        
        $parts = $compilationParts->find()->where(["compilation_id" => $compilation->id])->toArray();
        
        $isOkay = true;
        
        foreach ($parts as $part)
        {
            if($part->type == "Question")
            {
                $check = $questions->find()->where(["id" => $part->part_id])->toArray();
            }
            else if ($part->type == "Document")
            {
                $check = $uploads->find()->where(["id" => $part->part_id])->toArray();
            }
            
            if(empty($check))
            {
                $isOkay = false;
                
                if($compilation->is_active)
                {
                    $updateCompilation = $compilations->get($compilation->id);

                    $updateCompilation->is_active = false;

                    $compilations->save($updateCompilation);
                }
            }
        }
        
        return $isOkay;
    }
    
    public function checkSubject($subject)
    {
        $questions = TableRegistry::get("Questions");
        $answers = TableRegistry::get("Answers");
        
        $subjetAnswers = $answers->find()->where(["subject_id" => $subject->id])->toArray();
        
        $isOkay = true;
        
        foreach($subjetAnswers as $answer)
        {
            $check = $questions->find()->where(["id" => $answer->question_id])->toArray();
            
            if(empty($check))
            {
                $isOkay = false;
            }
        }
        
        return $isOkay;
    }
    
}