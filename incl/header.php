<?php
?>
<div class="wrapper-size">
    <form action="session.php" method="POST">
        <fieldset class="form-flex">
            <legend>Login</legend>
            <div>

                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="username" class="input">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="input">
            </div>

            <button type="submit" name="login" class="button">Skicka</button>
            <p><?= empty($_SESSION["incorrect"]) != false ? "" : $_SESSION["incorrect"]; ?></p>
        </fieldset>
    </form>

</div>