<div class="column">
    <div class="title">
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
            <div class="row">
                <button type="submit" name="action" value="add">Add User</button>
            </div>
            <?php if($addMessage != "") { ?>
                <div class="warning">
                    <?= $addMessage ?>
                </div>
            <?php } ?>
        </div>
    </form>
</div>
<div class="column">
    <div class="title">
        User List
    </div>
    <?php foreach($users as $item): ?>
    <form method="post">
        <div class="list-item">
            <input type="hidden" name="id" value="<?= $item->id ?>">
            <span>Username : <?= $item->username ?></span>
            <button type="submit" name="action" value="delete">Delete</button>
        </div>
    </form>
    <?php endforeach; ?>
    <?php if($deleteMessage != "") { ?>
    <div class="warning">
            <?= $deleteMessage ?>
        </div>
    <?php } ?>
</div>