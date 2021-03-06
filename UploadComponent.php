<?php
/*
To: src\Controller\Component\
Create folder uploads in webroot\.
*/
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class UploadComponent extends Component {
	
	public function processUpload() {
		
		$data = TableRegistry::get('Uploads');
		
		$allowedExts = array("pdf");
		$temp = explode(".", $_FILES['file']['name']);
		$extension = end($temp);
		
		if (($_FILES["file"]["type"] == "application/pdf")
		&& in_array($extension, $allowedExts)) {
			$uploaddir = "uploads";
			$uploadfile = $uploaddir . DS . basename($_FILES['file']['name']);
			$basename = basename($_FILES['file']['name']);

			if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				//echo "File is valid, and was successfully uploaded.\n";
				$file = $data->newEntity();
				$file->filename = "$basename";
				if($data->save($file)){
					$id = $file->id;
					$message = "File is valid and was successfully uploaded";
				}
			} else {
				//echo "File invalid. \n";
				$message = "Invalid file";
			}
		}else{
			//echo "File not allowed \n";
			$message = "File not allowed";
		}
		return $message;
	}
	
}


