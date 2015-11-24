<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Upload extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    
    protected function _getActive()
    {
        $compilationsTable = \Cake\ORM\TableRegistry::get("Compilations");
        
        $compilationPartsTable = \Cake\ORM\TableRegistry::get("Compilation_Parts");
        
        $compilationParts = $compilationPartsTable->find()->where(["part_id" => $this->id,"type" => "Document"])->toArray();
        
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




