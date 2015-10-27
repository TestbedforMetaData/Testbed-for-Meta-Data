<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Upload extends Entity {

    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    
    
    protected function _getName()
    {       
        return str_replace("_", " ", $this->filename);
    }
    
   

    

}




