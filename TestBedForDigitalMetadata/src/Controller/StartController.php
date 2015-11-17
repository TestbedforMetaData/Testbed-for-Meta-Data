<?php
namespace App\Controller;

use Cake\ORM\TableRegistry;

class StartController extends AppController {
	
	public function index() 
	{
		$c = TableRegistry::get("compilations");
		$comp = $c->find('all')->order('rand()')->first();
		$this->redirect(['controller'=>'start','action'=>'compilation',$comp->id,1]);
		
	}
	
	public function compilation($id, $order)
	{
		$uploads = TableRegistry::get("uploads");
		$loadquestions = TableRegistry::get("questions");
		$q = 0;
		$questions = array();
		$cP = TableRegistry::get("CompilationParts");
		$compilation = $cP->find()->where(["compilation_id" => $id, "visible_order >" => $order-1])->toArray();
		$prevcomp = $cP->find()->where(["compilation_id" => $id, "type" => "Document", "visible_order <" => $order])->order(["id" => "DESC"])->first();
		if($prevcomp != null){
			$prevdoc = $prevcomp->visible_order;
			$this->set("prevdoc",$prevdoc);
		}
		
		foreach($compilation as $result) {
			if($result["type"] == "Document" && $result["visible_order"] == $order){
				$document = $uploads->get($result->part_id);
				$this->set("document",$document);
			}else if($result["type"] == "Question"){
				$questions[$q] = $loadquestions->get($result->part_id);
				$q++;
			}
			else{
				$order = $result["visible_order"];
				$this->set("order",$order);
				$q = 0;
				break;
			}
		}
		$this->set("questions",$questions);
		$this->set("id",$id);
	}
}
