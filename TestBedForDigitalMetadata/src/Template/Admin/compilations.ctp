<div class="page-title">
    Administration
</div>
<div class="tab-container">
    <div class="tab-menu">
        <a href="<?= $this->Url->build(["action" => "documents"]) ?>">
            Documents
        </a>
        <a href="<?= $this->Url->build(["action" => "questions"]) ?>">
            Questions
        </a>
        <a href="<?= $this->Url->build(["action" => "answers"]) ?>">
            Answers
        </a>
        <span>
            Compilations
        </span>
    </div>
    <div class="tab-panel">
        <table>
            <tr>
                <td>
                    <ul class="link-list">
                        <?php foreach($compilations as $item): ?>
                        <li>
                            <a <?php if($id == $item->id){echo "class=\"selected\"" ;} ?> href="<?= $this->Url->build(["action" => "compilations",$item->id]) ?>">
                                <?= $item->name ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>  
                </td>
                <td>
                    <a href="<?= $this->Url->build(["action" => "compilations"]) ?>">Add new compilation</a>
                    <form method="post">
                        
                    
                    <div id="compilation" class="wide">
                        <div class="padded-small">
                            <input type="text" placeholder="Compilation Name" id="compilation-name" name="compilation-name" class="full-width" value="<?= $compilation->name ?>">
                        </div>
                        <div class="padded-small">
                            <select id="add-document">
                                <option value="-1">Select Document</option>
                                <?php foreach($documents as $item): ?>
                                <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;
                            <select id="add-question">
                                <option value="-1">Select Question</option>
                                <?php foreach($questions as $item): ?>
                                <option value="<?= $item->id ?>"><?= $item->text ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="items" class="padded-small">
                            <?php if($id != null) { ?>
                            <?php foreach($compilation->parts as $key => $item): ?>
                            
                            <div class='<?php if($item->type == "Question"){echo "question-item";}else{echo "document-item";} ?> comp-item'>
                                <span>
                                    <?= $item->text ?>
                                </span>
                                <input type='hidden' name='<?php if($item->type == "Question"){echo "question-".$item->id;}else{echo "document-".$item->id;} ?>' value='<?= $item->id ?>'>
                                <button type='button' id='remove-<?php if($item->type == "Question"){echo "question";}else{echo "document";} ?>'>X</button>
                            </div>
                            
                           
                            <?php endforeach; ?>
                            <?php } ?>
                        </div>
                        <div class="padded-small right">
                            <?php if ($id == null) { ?>
                            <button type="submit" id="submit-compilation" name="action" value="add">Add Compilation</button>
                            <?php } ?>
                        </div>
                        <div class="warning center">
                        </div>
                    </div>
                        </form>
                </td>
            </tr>
        </table>
    </div>
</div>