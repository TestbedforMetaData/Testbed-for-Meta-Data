<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class Compilation extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _getParts()
    {
        $questionsTable = TableRegistry::get("Questions");
        $uploadsTable = TableRegistry::get("Uploads");
        
        $compilationParts = TableRegistry::get("CompilationParts")->find()->where(["compilation_id" => $this->id])->order("visible_order")->toArray();
        
        $parts = array();
        
        $index = 1;
        
        foreach ($compilationParts as $item)
        {
            $obj = new \stdClass();
            
            $obj->index = $index++;
            $obj->id = $item->id;
            $obj->partId = $item->part_id;
            $obj->type = strtolower($item->type);
            
            if($item->type == "Document")
            {
                $obj->text = $uploadsTable->get($obj->partId)->name;
            }
            else if($item->type == "Question")
            {
                $obj->text = $questionsTable->get($obj->partId)->text;
            }
            
            array_push($parts, $obj);
        }
        
        return $parts;
        
    }

    
    

}

