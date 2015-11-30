

        <div class="content">

            <script>
                $(function ()
                {
                    $("#wizard").steps({
                        headerTag: "h2",
                        bodyTag: "section",
                        transitionEffect: "slideLeft",
                        stepsOrientation: "vertical"
                    });
                });
            </script>

            <div id="wizard">

                <h2>Document 1</h2>
                <section>
					<object data="../../../uploads/<?= $document->filename ?>" type="application/pdf" width="100%" height="800px">	 
					  <p>It appears you don't have a PDF plugin for this browser.</p>					  
					</object>
				
					<?php 
					foreach($questions as $item){
						echo "<h3>$item->text</h3><div class='question'>";
						if($item->type_id != 1){
							foreach($item->options as $key => $option):?>
							<div class="input-list">
								<input name="<?php echo $option->question_id ?>" id="<?php echo $option->id ?>" type="<?= $item->type ?>">
								<label for="<?php echo $option->id ?>"><?php echo $option->text ?></label>
							</div>
							<?php endforeach;
						}else{
							echo "<input type='text'> <br>";
						}
						echo "</div>";
					} ?>
					
					<div class="clearer"></div>
                </section>

                <h2>Document 2</h2>
                <section>
                    <p>Donec mi sapien, hendrerit nec egestas a, rutrum vitae dolor. Nullam venenatis diam ac ligula elementum pellentesque. 
                        In lobortis sollicitudin felis non eleifend. Morbi tristique tellus est, sed tempor elit. Morbi varius, nulla quis condimentum 
                        dictum, nisi elit condimentum magna, nec venenatis urna quam in nisi. Integer hendrerit sapien a diam adipiscing consectetur. 
                        In euismod augue ullamcorper leo dignissim quis elementum arcu porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Vestibulum leo velit, blandit ac tempor nec, ultrices id diam. Donec metus lacus, rhoncus sagittis iaculis nec, malesuada a diam. 
                        Donec non pulvinar urna. Aliquam id velit lacus.</p>
					<div class="clearer"></div>
                </section>

                <h2>Document 3</h2>
                <section>
                    <p>Morbi ornare tellus at elit ultrices id dignissim lorem elementum. Sed eget nisl at justo condimentum dapibus. Fusce eros justo, 
                        pellentesque non euismod ac, rutrum sed quam. Ut non mi tortor. Vestibulum eleifend varius ullamcorper. Aliquam erat volutpat. 
                        Donec diam massa, porta vel dictum sit amet, iaculis ac massa. Sed elementum dui commodo lectus sollicitudin in auctor mauris 
                        venenatis.</p>
					<div class="clearer"></div>
                </section>

                <h2>Document 4</h2>
                <section>
                    <p>Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula vulputate. Aliquam sed sem tortor. 
                        Quisque sed felis ut mauris feugiat iaculis nec ac lectus. Sed consequat vestibulum purus, imperdiet varius est pellentesque vitae. 
                        Suspendisse consequat cursus eros, vitae tempus enim euismod non. Nullam ut commodo tortor.</p>
					<div class="clearer"></div>
                </section>
					<div class="clearer"></div>
            </div>
        </div>

<!--
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
</div>-->