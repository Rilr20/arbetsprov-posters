<?php
// var_dump($_POST['url']);
switch ($_POST['process']) {
    case 'photos':
        $pdo = new PDO('mysql:host=localhost;dbname=posters', "root", "");
        $stmt_check = $pdo->prepare("SELECT imageurl from search where ?");
        $stmt = $pdo->prepare('INSERT INTO search (reviewed, imageurl) VALUES(?, ?)');
        $_SESSION['ai'] = [];
        for ($i = 0; $i < count($_POST["selection"]); $i++) {
            // var_dump($_POST["url_".$i]);

            $params = [$_POST['url'][$i]];
            // var_dump($stmt_check->execute($params));
            var_dump($stmt_check->execute($params) == 1);
            if ($stmt_check->execute($params) == 1) {
                // echo "empty";
                // var_dump($_POST["selection"][$i]);
                // echo $_POST["url"][$i];
                if ($_POST["selection"][$i] === 1)
                $params = [$_POST["selection"][$i], $_POST["url"][$i]];
                $stmt->execute($params);
                // echo "<br/>";
                header("Location: admin?page=ai")
            }
        }

        break;
    
    default:
        # code...
        break;
}
