<?php

$password = md5($_POST['password']);
$username = $_POST['username'];


$pdo = new PDO($_ENV['my_sql_dsn'], $_ENV['my_sql_username'], $_ENV['my_sql_password']);

$stmt = $pdo->prepare('SELECT username, password, is_admin FROM users where username = ?');
$params = [$username];
$stmt->execute($params);
$fetch = $stmt->fetch(PDO::FETCH_OBJ);

// var_dump($fetch);


// if (empty($stmt->fetch(PDO::FETCH_ASSOC))) {
//     var_dump("error");
// }

try {

    $tmp_password = $fetch->password;
    $tmp_username = $fetch->username;
    $is_admin = $fetch->is_admin;
    $md5_pasword = md5($password);

    // echo $md5_pasword;
    // echo "\n\n";
    // echo $tmp_password
    // echo $md5_pasword == $tmp_password;
    // echo $username == $tmp_username;
    if ($md5_pasword == $tmp_password && $username == $tmp_username) {
        $_SESSION["login"] = true;
        echo "tja";
        // if ($is_admin == 1) {
        header("Location: admin.php");
        // } else {
        //     header('Location: index');
        // }
    } else {
        header("Location: index.php");

    }
} catch (\Throwable $th) {
    //throw $th;
    // var_dump("error");

}
