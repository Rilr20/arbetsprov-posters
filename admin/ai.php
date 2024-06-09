<?php

$array = $_SESSION['ai'];
// var_dump($array);
function generateData($url)
{
    $yourApiKey = "AIzaSyBCc4q6u68-N1_Rl9JrS_pfOnRn4WaA-Bs";
    $client = Gemini::client($yourApiKey);
    // $url = "https://images.pexels.com/photos/593467/pexels-photo-593467.jpeg?auto=compress&cs=tinysrgb&dpr=1&fit=crop&h=200&w=280";
    $binaryData = base64_encode(file_get_contents($url));

    // $result = $client->geminiPro()->generateContent(['based on the image fill in this structure {    "title":"",    "header":"",    "description":"",    "keywords": [],}', $binaryData]);
    // $result->text();

    // What it would look like
    $result = '{"title": "Title for Image", "header": "Image", "description": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam repellat fugiat commodi magnam similique atque molestias fugit nemo necessitatibus officiis nisi placeat eius ducimus, hic eaque velit, deleniti suscipit voluptas.", "keywords": ["image", "generated", "cool"]}';
    try {
        //code...
        // 2/0;
        $data = json_decode($result);
        // var_dump($data->keys);
        if (!isset($data->url)) {
            $data->url = $url;
        }
        if (!isset($data->title)) {
            $data->title = "Title";
        }
        if (!isset($data->header)) {
            $data->header = "Header";
        }
        if (!isset($data->description)) {
            $data->description = "Description";
        }
        if (!isset($data->keywords)) {
            $data->keywords = ["keyword"];
        }
    } catch (\Throwable $th) {
        //throw $th;
        $skeletonObject = new stdClass();
        $skeletonObject->title = '';
        $skeletonObject->header = '';
        $skeletonObject->description = '';
        $skeletonObject->keywords = [];
        $data = $skeletonObject;
    }
    // var_dump($data);
    return $data;
}
$data = [];
foreach ($_SESSION['ai'] as $value) {
    # code...
    $res = generateData($value);
    array_push($data, $res);
}
?>

<h1>This is Ai Page Where you get Image Text</h1>
<?php foreach ($data as $key => $value) :  ?>
    <div>
        <img src="<?= $value->url ?>?auto=compress&cs=tinysrgb&dpr=1&fit=crop&h=200&w=280" alt="<?= $value->header ?>">
        <label for="title">Title</label>
        <input type="text" name="title" value="<?= $value->title ?>">
        <label for="header">Header</label>
        <input type="text" name="header" value="<?= $value->header ?>">
        <label for="description">Description</label>
        <textarea name="description" id="description" value=""><?= $value->description ?></textarea>
        <label for="keywords">Keywords, comma separated</label>
        <input type="text" name="keywords" value="<?= implode(', ', $value->keywords) ?>">
    </div>
<?php endforeach; ?>