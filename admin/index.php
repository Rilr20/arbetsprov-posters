<?php


// search for image

$data;
function ImageSearch($searchString): mixed
{

    $curl = curl_init();
    // $header = array();
    // $search = "nature";
    // $header[] = 'Authorization: xxjCiUcIHYdK5dqtEeqbJpf3b2dUmGrZLoi0ai4ueO9Nfkeoggmn6uB1';
    curl_setopt($curl, CURLOPT_URL, "https://api.pexels.com/v1/search?query=" . urlencode($searchString) . "&per_page=4");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPGET, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: " . PEXELSKEY
    ));
    $result = curl_exec($curl);
    curl_close($curl);
    // print_r($result);
    $data = json_decode($result);
    return $data;
}
// var_dump($data->photos[0]);
// echo "<br>";
// var_dump($data->photos[0]->src);
// var_dump($data->photos->src);

// var_dump($result);

// "Authorization: xxjCiUcIHYdK5dqtEeqbJpf3b2dUmGrZLoi0ai4ueO9Nfkeoggmn6uB1" \"https://api.pexels.com/v1/search?query=nature&per_page=1"
if (array_key_exists('search', $_POST)) {
    // var_dump($_POST);
    $search = $_POST["searchstring"];
    $data = ImageSearch($search);
    // var_dump($data);
}
?>
<h1>Admin Page</h1>
<form method="post">
    <input type="text" name="searchstring" id="searchstring">
    <button type="submit" name="search" value="">Search</button>
</form>
<form action="?process" method="POST">
    <?php if (is_object($data)) { ?>
        <?php foreach ($data->photos as $key => $value) :  ?>

            <div>
                <img src=<?= $value->src->tiny ?> alt=<?= $search ?>></img>
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