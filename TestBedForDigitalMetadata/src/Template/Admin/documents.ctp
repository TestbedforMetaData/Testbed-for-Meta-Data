<div class="page-title">
    Administration
</div>
<div class="tab-container">
    <div class="tab-menu">
        <a href="<?= $this->Url->build(["action" => "index"]) ?>">
            Instructions
        </a>
        <span>
            Documents
        </span>
        <a href="<?= $this->Url->build(["action" => "questions"]) ?>">
            Questions
        </a>
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
                        <?php foreach($uploads as $item): ?>
                        <li>
                            <a <?php if($id == $item->id){echo "class=\"selected\"" ;} ?> href="<?= $this->Url->build(["action" => "documents",$item->id]) ?>">
                                <?= $item->name ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>  
                </td>
                <td>
                    <a class="lnk" href="<?= $this->Url->build(["action" => "documents"]) ?>">Add new document</a>
                    <?php if ($message != "") { ?>
                    <div class="warning center">
                        <?= $message ?>
                    </div>
                    <?php } else { ?>
                    <form method="post" enctype="multipart/form-data">
                        <?php if($id != null && $active) { ?>
                        <div class="warning">
                            This document is part of an active compilation and can not be deleted.
                        </div>
                        <?php } ?>
                        <div id="document" class="wide">
                            <div class="padded-small">
                                <input type="text" placeholder="Document Name" id="document-name" name="document-name" class="full-width" value="<?php if($id != null){echo $document->name;} ?>">
                            </div>
                            <div class="padded-small">
                                <input type="file" name="file" id="file">
                            </div>
                            <?php if ($id != null){ ?>
                            <object data="../../uploads/<?= $document->filename ?>" type="application/pdf" width="100%" height="800px">	 
                                <p>It appears you don't have a PDF plugin for this browser.</p>					  
                            </object>
                            <div class="padded-small right">
                                <button type="submit" name="action" value="update" id="update-document">Update Document</button>&nbsp;&nbsp;&nbsp;<?php if(!$active){ ?><button type="submit" name="action" value="delete" id="delete-document">Delete Document</button><?php } ?>
                            </div>   
                            <?php } else { ?>
                            <div class="padded-small right">
                                <button type="submit" name="action" value="add" id="submit-document">Add Document</button>
                            </div>
                            <?php } ?>
                            <div class="warning center">
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>