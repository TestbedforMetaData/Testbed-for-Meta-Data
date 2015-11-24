<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Question extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _getOptions()
    {
        $optionsTable = \Cake\ORM\TableRegistry::get("options");
        
        return $optionsTable->find()->where(["question_id" => $this->id])->order("visible_order")->toArray();
    }

    protected function _getType()
    {
        if($this->type_id == 1)
        {
            return "text";
        }
        else if($this->type_id == 2)
        {
            return "radio";
        }
        else if($this->type_id == 3)
        {
            return "checkbox";
        }
    }
    
    protected function _getActive()
    {
        $compilationsTable = \Cake\ORM\TableRegistry::get("Compilations");
        
        $compilationPartsTable = \Cake\ORM\TableRegistry::get("Compilation_Parts");
        
        $compilationParts = $compilationPartsTable->find()->where(["part_id" => $this->id,"type" => "Question"])->toArray();
        
        $active = false;
        
        foreach($compilationParts as $item)
        {
            $compilation = $compilationsTable->get($item->compilation_id);
            
            if($compilation->is_active == 1)
            {
                $active = true;
            }
        }
        
        return $active;
    }
}

