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
                    <?php if($compilation != null) { ?>
                    <a class="lnk" href="<?= $this->Url->build(["action" => "compilations",$compilation->id]) ?>"><?= $compilation->name ?></a>
                    <?php } ?>
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
                    <?php if(!empty($answers)) { ?>
                    <input type="button" id="btnExport" value=" Export Table data into Excel " />
                    <div id="excel">
                        <table style="border:1px solid;border-collapse: collapse">
                            <tr>
                                <td style="border:1px solid">
                                    <?= $subjectName ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="border:1px solid">
                                    <?= $compilation->name ?>
                                </td>
                            </tr>
                            <?php foreach ($answers as $part): ?>
                            <tr>
                                <th style="border:1px solid;text-align: left">
                                    <?= $part->text ?>
                                </th>
                            </tr>
                            <?php if($part->type == "text") { ?>
                            <tr>
                                <td style="border:1px solid">
                                    <?= $part->answer_text ?>
                                </td>
                            </tr>
                            <?php } else if ($part->type == "radio") { ?>
                                <?php foreach ($part->options as $item): ?>
                                    <?php if($item->checked) {?>
                                        <tr>
                                            <td style="border:1px solid">
                                                <?= $item->text ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php endforeach; ?>
                            <?php } else if ($part->type == "checkbox") { ?>
                                <?php foreach ($part->options as $item): ?>
                                    <?php if($item->checked) { ?>
                                        <tr>
                                            <td style="border:1px solid">
                                                <?= $item->text ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php endforeach; ?>
                            <?php } ?>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>