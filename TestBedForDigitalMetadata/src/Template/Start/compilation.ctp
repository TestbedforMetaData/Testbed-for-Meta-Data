<div class="column">
	<div class="document-display">
		<embed src="../../../uploads/<?= $document->filename ?>" width="700" height="800" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
	</div>
	<br>
	<div class="questions-list">
		<form method="post">
			<?php 
			foreach($questions as $item){
				echo "$item->text <br>";
				if($item->type_id != 1){
					foreach($item->options as $key => $option):?>
					<div class="input-list">
						<input type="<?= $item->type ?>">
						<span><?php echo $option->text ?></span>
					</div>
					<?php endforeach;
				}else{
					echo "<input type='text'> <br>";
				}
				echo "<br>";
			} ?>
		</form> 
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
