<div class="page-title">
    Administration
</div>
<div class="tab-container">
    <div class="tab-menu">
        <a href="<?= $this->Url->build(["action" => "documents"]) ?>">
            Documents
        </a>
        <span>
            Questions
        </span>
        <a href="<?= $this->Url->build(["action" => "answers"]) ?>">
            Answers
        </a>
        <a href="<?= $this->Url->build(["action" => "compilations"]) ?>">
            Compilations
        </a>
    </div>
    <div class="tab-panel">
        <table>
            <tr>
                <td>
                    <ul class="link-list">
                        <?php foreach($questions as $item): ?>
                        <li>
                            <a <?php if($id == $item->id){echo "class=\"selected\"" ;} ?> href="<?= $this->Url->build(["action" => "questions",$item->id]) ?>">
                                <?= $item->name ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>  
                </td>
                <td>
                    <a href="<?= $this->Url->build(["action" => "questions"]) ?>">Add new question</a>
                    <?php if ($added) { ?>
                    <div class="warning center">
                        <?= $message ?>
                    </div>
                    <?php } else{ ?>
                    <form method="post">
                        <div id="question" class="wide">
                        <div class="padded-small">
                            <input type="text" placeholder="Question Name" id="question-name" name="question-name" class="full-width" value="<?php if($id != null){echo $question->name;} ?>">
                        </div>
                        <div class="padded-small">
                            <textarea placeholder="Question" rows="3" id="question-text" name="question-text" class="full-width"><?php if($id != null){echo $question->text;} ?></textarea>
                        </div>
                        <div id="type" class="padded-small">
                            <span>Question Type:</span>
                            <select id="question-type" name="question-type">
                                <option value="1" <?php if($id != null && $question->type_id == 1){echo "selected";} ?>>
                                    Text
                                </option>
                                <option value="2" <?php if($id != null && $question->type_id == 2){echo "selected";} ?>>
                                    Radio
                                </option>
                                <option value="3" <?php if($id != null && $question->type_id == 3){echo "selected";} ?>>
                                    Checkbox
                                </option>
                            </select>
                        </div>
                        <div id="options" class="padded-small">
                            <?php if($id != null && $question->type != 1) { ?>
                            <?php foreach($question->options as $key => $option): ?>
                            <div class="option-item">
                                <input checked disabled type="<?= $question->type ?>">
                                <input type="text" name="option-<?= $key + 1 ?>" value="<?= $option->text ?>">                               
                                <button type='button' id='delete-option'>X</button>
                            </div>
                            <?php endforeach; ?>
                            <?php } ?>
                        </div>
                        <div class="padded-small right">
                            <?php if ($id == null) { ?>
                            <button type="submit" id="submit-question" name="action" value="add">Add Question</button>
                            <?php } ?>
                        </div>
                        <div class="warning center">
                            <?= $message ?>
                        </div>
                    </div>
                        </form>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>