<div class="column">
	<div class="document-display">
		<embed src="../../../uploads/<?= $document->filename ?>" width="700" height="800" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
	</div>
	<br>
	<div class="questions-list">
		<ul class="q-list">
			<?php foreach($questions as $item):
			echo "<li>";
				echo "$item->text";
			echo "</li>";
			endforeach; ?>
		</ul>  
	</div>
	<br>
	<div class="navigation-buttons">
	<?php if(isset($prevdoc)) { ?>
	<a href="<?= $this->Url->build(["action" => "compilation",$id,$prevdoc]) ?>">Previous</a>
	<?php 
	}else{
		echo "Previous";
	}
	?>
	<?php if(isset($order)) { ?>
	<a href="<?= $this->Url->build(["action" => "compilation",$id,$order]) ?>">Next</a>
	<?php
	}else{
		echo "Next";
	}
	?>
	</div>
</div>
