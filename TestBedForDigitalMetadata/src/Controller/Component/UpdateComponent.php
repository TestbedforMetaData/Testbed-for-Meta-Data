<?php


namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class UpdateComponent extends Component {
    
    
    public function checkUpdate($new,$old)
    {
        $result = true;
        
        $countNew = count($new);
        $countOld = count($old);
        
        if($countNew != $countOld)
        {
            $result = false;
        }
        else
        {
            $allSame = true;
            
            foreach($new as $i)
            {
                $contains = false;
                
                foreach ($old as $j)
                {
                    if($i->id == $j->id)
                    {
                        $contains = true;
                    }
                }
                
                if(!$contains)
                {
                    $allSame = false;
                }
            }
            
            if(!$allSame)
            {
                $result = false;
            }
        }
        
        return $result;
        
    }
    
    
}
