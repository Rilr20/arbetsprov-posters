<?php


// search for image

$data = [];
function ImageSearch($searchString, $perpage = 4): mixed
{

    unset($_SESSION["searchinfo"]);
    if ($searchString == "") {
        $_SESSION["searchinfo"] = "Missing search string";
        return [];
    }
    
    $curl = curl_init();

    if ($searchString == "POST_random") {

        curl_setopt($curl, CURLOPT_URL,  "https://api.pexels.com/v1/curated?per_page=$perpage");
        
    } else {
        echo "else";
        curl_setopt($curl, CURLOPT_URL,  "https://api.pexels.com/v1/search?query=" . urlencode($searchString) . "&per_page=$perpage");

    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPGET, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: " . $_ENV['API_pexels']
    ));
    $result = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($result);


    $params = [];
    //sort for original url
    foreach ($data->photos as $photo) {

        array_push($params, $photo->src->original);
    }


    if (count($params) != 0) {
        $pdo = new PDO('mysql:host=localhost;dbname=posters', "root", "");
        $in = str_repeat("?,", count($params) - 1) . "?";

        $stmt = $pdo->prepare("SELECT imageurl FROM search WHERE imageurl in ($in)");
        $stmt->execute($params);
        $stmtres = $stmt->fetchAll();

        // Remove them from $data variable.
        foreach ($stmtres as $url) {
            foreach ($data->photos as $key => $datavalue) {
                if ($datavalue->src->original == $url["imageurl"]) {
                    unset($data->photos[$key]);
                    break;
                }
            }
        }


    }
    // var_dump($data);
    if (count($data->photos) == 0) {
        $_SESSION["searchinfo"] = "No new images found";
    }
    // var_dump($data->photos[0]->src);
    echo '<pre>', var_dump($data->photos[0]->src), '</pre>';
    return $data;
}

if (array_key_exists('search', $_POST)) {
    // var_dump($_POST);
    $search = $_POST["searchstring"];
    $data = ImageSearch($search);
    // var_dump($data);
}
if (array_key_exists('random', $_POST)) {
    $data = ImageSearch("POST_random");
}
?>
<h1>Admin Page</h1>
<form method="post">
    <input type="text" name="searchstring" id="searchstring">
    <button type="submit" name="search" value="">Search</button>
    <button type="submit" name="random" value="">Random</button>
</form>
<form action="?page=process" method="POST">
    <p <?php (isset($_SESSION["searchinfo"])) ? "hidden" : ""  ?>><?= (isset($_SESSION["searchinfo"])) ? $_SESSION["searchinfo"]  : "" ?></p>
    <?php if (is_object($data)) { ?>
        <?php foreach ($data->photos as $key => $value) :  ?>

            <div>
                <img src=<?= $value->src->tiny ?> alt=<?= $search ?? "random" ?>></img>
            </div>
            <input id="yes-<?= $key ?>" type="radio" name="selection[<?= $key ?>]" value="1" required>
            <label for="yes-<?= $key ?>">yes</label>
            <input id="no-<?= $key ?>" type="radio" name="selection[<?= $key ?>]" value="0" required>
            <label for="no-<?= $key ?>">no</label>
            <input type="hidden" name="url[<?= $key ?>]" value="<?= $value->src->original ?>">
        <?php endforeach; ?>
    <?php } ?>
    <input type="hidden" name="process" value="photos">
    <button>submit</button>

</form>