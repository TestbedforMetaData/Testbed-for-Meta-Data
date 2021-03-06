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
                    <a class="lnk" href="<?= $this->Url->build(["action" => "compilations"]) ?>">Add new compilation</a>
                    <?php if ($added) { ?>
                    <div class="warning center">
                        <?= $message ?>
                    </div>
                    <?php } else{ ?>
                    <form method="post">
                    <div id="compilation" class="wide">
                        <div class="padded-small">
                            <input type="text" placeholder="Compilation Name" id="compilation-name" name="compilation-name" class="full-width" value="<?php if($id != null) {echo $compilation->name;} ?>">
                        </div>
                        <?php if($id != null) { ?>
                        <div class="padded-small">
                            <a class="small-link" href="<?= $url ?>"><?= $url ?></a> 
                        </div>
                        <?php } ?>
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
                                <option value="<?= $item->id ?>"><?= $item->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="items" class="padded-small">
                            <?php if($id != null) { ?>
                            <?php foreach($compilation->parts as $key => $item): ?>
                            
                            <div class='<?= $item->type."-item" ?> comp-item'>
                                <span><?= $item->name ?></span><input type='hidden' name='<?= $item->type."-".$item->index ?>' value='<?= $item->partId ?>'><input type="hidden" name="<?= $item->type."-id-".$item->index ?>" value="<?= $item->id ?>"><button type='button' class="delete" id='remove-<?= $item->type ?>'>X</button>
                            </div>
                            
                           
                            <?php endforeach; ?>
                            <?php } ?>
                        </div>
                        <?php if ($id != null) { ?>
                        <div class="padded-small">
                            <input type="checkbox" id="compilation-active" name="compilation-active" class="full-width" <?php if($compilation->is_active == 1){echo "checked";} ?>><span>Compilation is active</span>
                        </div>
                        <?php } ?>
                        <div class="padded-small right">
                            <?php if ($id == null) { ?>
                            <button type="submit" id="submit-compilation" name="action" value="add">Add Compilation</button>
                            <?php } else { ?>
                            <button type="submit" id="submit-compilation" name="action" value="update">Update Compilation</button>
                            &nbsp;&nbsp;
                            <button type="submit" id="delete-compilation" name="action" value="delete">Delete Compilation</button>
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