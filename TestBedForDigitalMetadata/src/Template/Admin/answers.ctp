<div class="page-title">
    Administration
</div>
<div class="tab-container">
    <div class="tab-menu">
        <a href="<?= $this->Url->build(["action" => "index"]) ?>">
            Instructions
        </a>
        <a href="<?= $this->Url->build(["action" => "documents"]) ?>">
            Documents
        </a>
        <a href="<?= $this->Url->build(["action" => "questions"]) ?>">
            Questions
        </a>
        <span>
            Answers
        </span>
        <a href="<?= $this->Url->build(["action" => "compilations"]) ?>">
            Compilations
        </a>
    </div>
    <div class="tab-panel">
        <table>
            <tr>
                <td>
                    <ul class="link-list">
                        <?php foreach($subjects as $item): ?>
                        <li>
                            <a <?php if($id == $item->id){echo "class=\"selected\"" ;} ?> href="<?= $this->Url->build(["action" => "answers",$item->id]) ?>">
                                <?= $item->name ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>  
                </td>
                <td>
                    <?php foreach ($answers as $part): ?>
                    <div class="answer-div">
                        <div class="answer-question">
                            <?= $part->order.". ".$part->text ?>
                        </div>
                        <?php if($part->type == "text") { ?>
                        <div class="answer-text">
                            &nbsp;<?= $part->answer_text ?>
                        </div>
                        <?php } else if ($part->type == "radio") { ?>
                            <?php foreach ($part->options as $item): ?>
                            <div class="answer-text">
                                <input type="radio" disabled <?php if($item->checked) {echo "checked";} ?>>
                                <span><?= $item->text ?></span>
                            </div>
                            <?php endforeach; ?>
                        <?php } else if ($part->type == "checkbox") { ?>
                            <?php foreach ($part->options as $item): ?>
                            <div class="answer-text">
                                <input type="checkbox" disabled <?php if($item->checked) {echo "checked";} ?>>
                                <span><?= $item->text ?></span>
                            </div>
                            <?php endforeach; ?>
                        <?php } ?>
                    </div>
                    <?php endforeach; ?>
                </td>
            </tr>
        </table>
    </div>
</div>