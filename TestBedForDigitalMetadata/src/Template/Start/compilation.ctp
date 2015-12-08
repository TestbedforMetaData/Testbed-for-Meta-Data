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
    <?php if(!$post) { ?>
    <form method="post" id="answer-form">
        <div id="wizard">
            <h2>Instructions</h2>
            <section>
                <?= $instructions ?>
            </section>
            <?php foreach($components as $item): ?>
            <h2><?= $item->title ?></h2>
            <section>
                <?php if($item->type == "Document"){ ?>
                    <object data="../../uploads/<?= $item->fileName ?>" type="application/pdf" width="100%" height="800px">	 
			<p>It appears you don't have a PDF plugin for this browser.</p>					  
                    </object>
                <?php } else if($item->type == "Question"){ ?>	
                    <h3><?= $item->text ?></h3>
                    <div class="question">
                    <?php if($item->hasOptions) { ?>
                        <?php foreach($item->options as $option): ?>
                        <div class="input-list">
                            <?php if($item->questionType == "checkbox") { ?>
                            <input type="<?= $item->questionType ?>" name="question-<?= $item->questionId ?>-option-<?= $option->id ?>" id="question-<?= $item->questionId ?>-option-<?= $option->id ?>">
                            <label for="question-<?= $item->questionId ?>-option-<?= $option->id ?>"><?= $option->text ?></label>
                            <?php } else if ($item->questionType == "radio") { ?>
                            <input type="<?= $item->questionType ?>" name="question-<?= $item->questionId ?>" value="<?= $option->id ?>" id="question-<?= $item->questionId ?>-option-<?= $option->id ?>">
                            <label for="question-<?= $item->questionId ?>-option-<?= $option->id ?>"><?= $option->text ?></label>
                            <?php } ?>
                        </div>
                        <?php endforeach; ?>
                    <?php } else { ?>
                        <textarea  name="question-<?= $item->questionId ?>-text" id="question-<?= $item->questionId ?>-text"></textarea>
                    <?php } ?>
                    </div>
                    <div class="clearer"></div>
                    <?php } ?>
            </section>
            <?php endforeach; ?>
            <h2>Submit</h2>
            <section>
                <h3>Enter your name or email</h3>
                <input type="text" name="user-name" id="submit-user">
                <div class="warning" id="user-name-valid"></div>
            </section>
               
            </div>
            </form>
    <?php } else { ?>
    <div>
        <?php 
        
        if($success)
        {
            echo "Your answers are submitted successfully, thank you for your participation.";
        }
        else
        {
            echo "An error occured during submit.";
        }
        
        ?>
    </div>
    <?php } ?>
        </div>

