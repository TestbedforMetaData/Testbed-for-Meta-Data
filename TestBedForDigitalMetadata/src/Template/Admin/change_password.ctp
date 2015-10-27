<div class="center top-pad">
<div class="panel">
<form method="post">
        <div class="form-container"> 
            <div class="row">
                <span class="label">Old Password:</span>
                <input type="password" name="old-password" class="description">
            </div>
            <div class="row">
                <span class="label">New Password:</span>
                <input type="password" name="new-password" class="description">
            </div>
            <div class="row">
                <button type="submit" name="action" value="add">Change Password</button>
            </div>
            <?php if($addMessage != "") { ?>
                <div class="warning">
                    <?= $addMessage ?>
                </div>
            <?php } ?>
        </div>
    </form>
    </div>
</div>