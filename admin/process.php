<?php
// var_dump($_POST['url']);
switch ($_POST['process']) {
    case 'photos':
        /**
         * Yes 1
         * No 0
         */
        if(empty($_POST['selection'])) {
            var_dump($_POST['selection']);
            $_SESSION["searchinfo"] = "Nothing to Send";
            header("Location: admin.php");

        }
        $pdo = new PDO($_ENV['mysql_dsn'], $_ENV['mysql_username'], $_ENV['mysql_password']);
        $stmt_check = $pdo->prepare("SELECT imageurl from search where imageurl = ?");
        $stmt = $pdo->prepare('INSERT INTO search (reviewed, imageurl) VALUES(?, ?)');
        $_SESSION['ai'] = [];

        for ($i = 0; $i < count($_POST["selection"]); $i++) {

            $params = [$_POST['url'][$i]];

            $stmt_check->execute($params);

            $result = $stmt_check->fetch();

            if (empty($result)) {

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
    case 'generation':
        for ($i = 0; $i < count($_POST['title']); $i++) {
            $title = $_POST['title'][$i];
            $header = $_POST['header'][$i];
            $description = $_POST['description'][$i];
            $url = $_POST['url'][$i];
            $keywords = explode(",", $_POST['keywords'][$i]);

            $pdo = new PDO($_ENV['mysql_dsn'], $_ENV['mysql_username'], $_ENV['mysql_password']);
            $posterId = CreatePoster($pdo, $header, $title, $description, $url);
            AddKeywords($pdo, $posterId, $keywords);
            header("Location: admin.php");
        }
        break;
        // default:
        //     # code...
        //     header("Location: index.php");

        //     break;
}
function CreatePoster($pdo, $header, $title, $description, $url): int
{
    $thumbnailUrl = "$url?auto=compress&cs=tinysrgb&dpr=1&fit=crop&h=200&w=280";
    $stmt = $pdo->prepare('INSERT INTO posters (title, description, header, image, thumbnail) VALUES (?,?,?,?,?)');
    $image = file_get_contents("$url?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940");
    $thumbnail = file_get_contents($thumbnailUrl);
    $stmt->execute([$title, $description, $header, $image, $thumbnail]);
    return $pdo->lastInsertId();
}
function AddKeywords($pdo, $posterId, $keywords)
{
    $stmtSelect = $pdo->prepare('SELECT id, keyword FROM keywords WHERE keyword = ?');
    $stmtCreate = $pdo->prepare('INSERT INTO keywords (keyword) VALUES (?)');
    $stmtConnect = $pdo->prepare('INSERT INTO poster_to_keywords (poster_id, keyword_id)  VALUES (?,?)');
    foreach ($keywords as $keyword) {
        $stmtSelect->execute([$keyword]);
        $result = $stmtSelect->fetch();
        //check if keyword exists
        if (empty($result)) {
            //Create keyword if it doesn't
            $stmtCreate->execute([$keyword]);
            $keywordId = $pdo->lastInsertId();
        } else {
            // var_dump($result["id"]);
            $keywordId = $result["id"];
        }
        //Get the keyword id, add it to poster_to_keywords
        $stmtConnect->execute([$posterId, $keywordId]);
    }


}
