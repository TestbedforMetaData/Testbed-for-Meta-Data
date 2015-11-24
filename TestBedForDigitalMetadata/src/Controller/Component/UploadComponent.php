<?php
/*
To: src\Controller\Component\
Create folder uploads in webroot\.
*/
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class UploadComponent extends Component {
	
	public function processUpload($name = "") {
		
		$data = TableRegistry::get('Uploads');
		
		$allowedExts = array("pdf");
		$temp = explode(".", $_FILES['file']['name']);
		$extension = end($temp);
                $fileName = str_replace(" ", "_", basename($_FILES['file']['name']));
		
		if (in_array($extension, $allowedExts)) {
			$uploaddir = WWW_ROOT."uploads";
			$uploadfile = $uploaddir . DS . $fileName;
			$basename = $fileName;

			if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				//echo "File is valid, and was successfully uploaded.\n";
				$file = $data->newEntity();
				$file->filename = "$basename";
                                $file->name = $name;
				if($data->save($file)){
					chmod($uploadfile, 0755);
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
        
        public function updateDocument($id,$name = "")
        {
            $data = TableRegistry::get('Uploads');
		
            
            if($_FILES["file"]["size"] == 0)
            {
                $file = $data->get($id);
                
                $file->name = $name;
                
                if($data->save($file))
                {
                    $message = "Document is updated";
                }
                else
                {
                    $message = "An error occured when updating document";
                }
            }
            else
            {
		$allowedExts = array("pdf");
		$temp = explode(".", $_FILES['file']['name']);
		$extension = end($temp);
                $fileName = str_replace(" ", "_", basename($_FILES['file']['name']));
		
		if (in_array($extension, $allowedExts)) {
			$uploaddir = WWW_ROOT."uploads";
			$uploadfile = $uploaddir . DS . $fileName;
			$basename = $fileName;
                        
                        $file = $data->get($id);
                        
                        $oldFilePath = WWW_ROOT."uploads".DS.$file->filename;

			if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
				//echo "File is valid, and was successfully uploaded.\n";
				
                                if($uploadfile != $oldFilePath)
                                {
                                    unlink($oldFilePath);
                                }
                            
				$file->filename = "$basename";
                                $file->name = $name;
				if($data->save($file)){
					chmod($uploadfile, 0755);
					$id = $file->id;
					$message = "Document is updated";
				}
			} else {
				//echo "File invalid. \n";
				$message = "Invalid file";
			}
		}else{
			//echo "File not allowed \n";
			$message = "File not allowed";
		}
            }
		return $message;
        }
        
        public function deleteDocument($id)
        {
            $data = TableRegistry::get('Uploads');
            
            $file = $data->get($id);
            
            $filePath = WWW_ROOT."uploads".DS.$file->filename;
            
            if(unlink($filePath))
            {
                if($data->delete($file))
                {
                    $message = "Document deleted";
                }
                else
                {
                    $message = "An error occured";
                }
            }
            else
            {
                $message = "An error occured";
            }
               
            return $message;
                
        }
	
}


