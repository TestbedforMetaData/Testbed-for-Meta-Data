<div class="page-title">
    Administration
</div>
<div class="tab-container">
    <div class="tab-menu">
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
                    <a href="<?= $this->Url->build(["action" => "documents"]) ?>">Add new document</a>
                    <?php if ($message != "") { ?>
                    <div class="warning center">
                        <?= $message ?>
                    </div>
                    <?php } else if ($id == null) { ?>
                    <form method="post" enctype="multipart/form-data">
                        <div id="document" class="wide">
                            <!--<div class="padded-small">
                                <input type="text" placeholder="Document Name" id="document-name" name="document-name" class="full-width">
                            </div>-->
                            <div class="padded-small">
                                <input type="file" name="file" id="file">
                            </div>
                            <div class="padded-small right">
                                <button type="submit" id="submit-document">Add Document</button>
                            </div>
                            <div class="warning center">
                            </div>
                        </div>
                    </form>
                    <?php } else { ?>
                    <embed src="../../uploads/<?= $document->filename ?>" width="700" height="800" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>