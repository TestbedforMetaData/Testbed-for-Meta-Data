<!-- 
To: src\Template\Upload\
-->
<div class="column">
    <div class="title">
        Upload a document
    </div>
    <form enctype="multipart/form-data" method="POST">
        <div class="form-container">
			<input type="hidden" name="issubmit" value="1" />
            <div class="row">
                <span class="label">Select file:</span>
                <input type="file" name="file">
            </div>
			
            <div class="row">
                <input type="submit" value="Upload" />
            </div>
			<?php if($message != "") { ?>
                <div class="warning">
                    <?= $message ?>
                </div>
            <?php } ?>
        </div>
    </form>
</div>
