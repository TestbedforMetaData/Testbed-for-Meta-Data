<div class="center top-pad">
<div class="panel">
    <form method="post">
        <div class="form-container"> 
            <div class="row">
                <span class="label">Username:</span>
                <input type="text" name="username" class="description">
            </div>
            <div class="row">
                <span class="label">Password:</span>
                <input type="password" name="password" class="description">
            </div>
            <div class="row">
                <button type="submit">Log In</button>
            </div>
            <?php if($error) { ?>
            <div class="warning">
                Incorrect username or password !
            </div>
            <?php } ?>
        </div>
    </form>
</div>
</div>