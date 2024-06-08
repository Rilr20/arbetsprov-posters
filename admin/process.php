<?php
// var_dump($_POST['url']);
switch ($_POST['process']) {
    case 'photos':
        /**
         * Yes 1
         * No 0
         */
        $pdo = new PDO('mysql:host=localhost;dbname=posters', "root", "");
        $stmt_check = $pdo->prepare("SELECT imageurl from search where imageurl = ?");
        $stmt = $pdo->prepare('INSERT INTO search (reviewed, imageurl) VALUES(?, ?)');
        $_SESSION['ai'] = [];
        
        for ($i = 0; $i < count($_POST["selection"]); $i++) {
            // var_dump($_POST["url_".$i]);

            $params = [$_POST['url'][$i]];
            // var_dump($_POST["selec"]);
            // var_dump($stmt_check->execute($params));
            $stmt_check->execute($params);
            // var_dump($stmt_check->execute());
            $result = $stmt_check->fetch();
            // var_dump(empty($result));
            if (empty($result)) {
                // echo "empty";
                // var_dump($_POST["selection"][$i]);
                // var_dump($_POST["url"][$i]);
                // echo $_POST["url"][$i];
                if ($_POST["selection"][$i] == 1) {
                    // var_dump($_POST["selection"][$i]);
                    array_push($_SESSION['ai'], $_POST["url"][$i]);
                    var_dump($_SESSION["ai"]);
                }
                $params = [$_POST["selection"][$i], $_POST["url"][$i]];
                $stmt->execute($params);
                // echo "<br/>";
                header("Location: admin.php?page=ai");
            }
        }

        break;
    
    default:
        # code...
        break;
}
