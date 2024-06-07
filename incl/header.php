<?php
?>
<div>
    <form action="session.php" method="POST">
        <fieldset>
            <legend>Login</legend>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="username" class="input">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="input">

            <button type="submit" name="login" class="button">Skicka</button>
            <p><?= empty($_SESSION["incorrect"]) != false ? "" : $_SESSION["incorrect"]; ?></p>
        </fieldset>
    </form>

</div>