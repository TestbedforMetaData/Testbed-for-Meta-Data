<?php
/*
To: src\Controller\
For database
enter this query:
CREATE TABLE `testmeta`.`uploads` ( `id` INT NOT NULL AUTO_INCREMENT , `filename` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
*/
namespace App\Controller;

class UploadController extends AppController {

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);
        
        $user = $this->Auth->user();
        
        if($user == null)
        {
            return $this->redirect(["controller" => "Home"]);
        }
    }
	
	public function index() 
	{
		$this->loadComponent('Upload');
		$message = "";
		if($this->request->is("post"))
		{
			$message = $this->Upload->processUpload();
		}
		$this->set("message",$message);
	}
}
