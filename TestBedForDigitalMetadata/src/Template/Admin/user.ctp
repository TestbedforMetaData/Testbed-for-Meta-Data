<div class="column-half padded">
    <div class="title center">
        Create New User
    </div>
    <form method="post">
        <div class="form-container"> 
            <div class="row">
                <span class="label">Username:</span>
                <input type="text" name="username">
            </div>
            <div class="row">
                <span class="label">Password:</span>
                <input type="password" name="password">
            </div>
            <div class="row center">
                <button type="submit" name="action" value="add">Add User</button>
            </div>
            <?php if($addMessage != "") { ?>
                <div class="warning center">
                    <?= $addMessage ?>
                </div>
            <?php } ?>
        </div>
    </form>
</div>
<div class="column-half padded">
    <div class="list">
    <div class="list-header">
        User List
    </div>
    <?php foreach($users as $item): ?>
    
        <div class="list-item">
            <form method="post">
            <input type="hidden" name="id" value="<?= $item->id ?>">
            <span>Username : <?= $item->username ?></span>
            <button type="submit" name="action" value="delete">Delete</button>
            </form>
        </div>
    
    <?php endforeach; ?>
    <?php if($deleteMessage != "") { ?>
    <div class="warning">
            <?= $deleteMessage ?>
        </div>
    <?php } ?>
    </div>
</div>