<div class="page-title">
    Administration
</div>
<div class="tab-container">
    <div class="tab-menu">
        <span>
            Instructions
        </span>
        <a href="<?= $this->Url->build(["action" => "documents"]) ?>">
            Documents
        </a>
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
        
        <?= $this->Html->script('tinymce/tinymce.min.js') ?>
        <?= $this->fetch('script') ?>
        <script type="text/javascript">
            tinymce.init({
                    selector: "#mytext",
                    width: 600,
                    height: 300,
                    plugins: [
                 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                 "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons"
                });
        </script>
        <form method="post">
            <table>
            <tr>
                <td>
                    <textarea name="instruction-text" id="mytext"><?= $instructions ?></textarea>
                </td>
            </tr>
            <tr>
                <td style="text-align: right">
                    <button type="submit">Update</button>
                </td>
            </tr>
        </table> 
        </form>
    </div>
</div>