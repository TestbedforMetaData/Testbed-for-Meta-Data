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
            <button type="submit">Log In</button>
        </div>
        <?php if($error) { ?>
        <div class="warning">
            Incorrect username or password !
        </div>
        <?php } ?>
    </div>
</form>