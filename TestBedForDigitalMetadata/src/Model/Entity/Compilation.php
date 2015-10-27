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
        
        $compilationParts = TableRegistry::get("CompilationParts")->find()->order("visible_order")->toArray();
        
        $parts = array();
        
        foreach ($compilationParts as $item)
        {
            $obj = new \stdClass();
            
            $obj->id = $item->part_id;
            $obj->type = $item->type;
            
            if($item->type == "Document")
            {
                $obj->text = $uploadsTable->get($obj->id)->name;
            }
            else if($item->type == "Question")
            {
                $obj->text = $questionsTable->get($obj->id)->text;
            }
            
            array_push($parts, $obj);
        }
        
        return $parts;
        
    }

    
    

}

