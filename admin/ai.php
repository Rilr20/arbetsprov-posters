<?php


$array = $_SESSION['ai'];
// var_dump($array);
class Result
{
    // Implement the text() method to return "Hello World"
    public function text()
    {
        return '{"title": "Title for Image", "header": "Image", "description": "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam repellat fugiat commodi magnam similique atque molestias fugit nemo necessitatibus officiis nisi placeat eius ducimus, hic eaque velit, deleniti suscipit voluptas.", "keywords": ["image", "generated", "cool"]}';
    }
}
function generateData($url)
{
    $yourApiKey = $_ENV["API_openai"];#Todo: change variable
    
    $client = OpenAi::client($yourApiKey);
    $url = "$url?auto=compress&cs=tinysrgb&dpr=1&fit=crop&h=200&w=280";
    // echo '<pre>', var_dump($client->chat()), '</pre>';

    $result = $client->chat()->create([
        'model' => 'gpt-4-vision-preview',
        'messages' => [
            [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => 'based on the image only return this structure {"title":"","header":"","description":"","keywords": [],}'],
                    ['type' => 'image_url', 'image_url' => "$url"],
                ],
            ]
        ],
        'max_tokens' => 900,
    ]);

    // return $result->choices[0]->message->content;
    // $binaryData = new Blob(MimeType::IMAGE_JPEG, base64_encode(file_get_contents(($url))));

    // $result = $client->geminiProVision()->generateContent(['based on the image fill in this structure {    "title":"",    "header":"",    "description":"",    "keywords": [],}', $binaryData]);
    // $result->text();

    $data = $result->choices[0]->message->content;
    //example
    //```json { "title":"Monkey Looking at Reflection", "header":"A Curious Monkey with a Mirror", "description":"This photo captures a moment where a monkey is looking at its own reflection in a handheld mirror. The monkey appears to be intently examining itself, providing a sense of curiosity and self-awareness that is often attributed to primates.", "keywords": ["monkey", "reflection", "mirror", "self-awareness", "curiosity", "animal behavior", "primate", "nature"] } ```

    try {
        //code...
        // 2/0;
        $data = json_decode($result->text());
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
<form action="?page=process" method="POST">
    <div class="previews">
        <?php foreach ($data as $key => $value) :  ?>
            <div class="parent ">
                <div class="div1">

                    <img src="<?= $value->url ?>?auto=compress&cs=tinysrgb&dpr=1&fit=crop&h=200&w=280" alt="<?= $value->header ?>">
                </div>
                <div class="div2 input-flex">

                    <label for="title">Title</label>
                    <input type="text" name="title" value="<?= $value->title ?>">
                </div>
                <div class="div3 input-flex">

                    <label for="header">Header</label>
                    <input type="text" name="header" value="<?= $value->header ?>">
                </div>
                <div class="div4 input-flex">

                    <label for="description">Description</label>
                    <textarea name="description" id="description" value=""><?= $value->description ?></textarea>
                </div>
                <div class="div5 input-flex">

                    <label for="keywords">Keywords*</label>
                    <input type="text" name="keywords" value="<?= implode(', ', $value->keywords) ?>">
                    <p>*Comma separated</p>
                </div>
                <input type="hidden" name="url[<?= $key ?>]" value="<?= $_SESSION['ai'][$key] ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <input type="hidden" name="process" value="generation">
    <button type="submit">Validated</button>
</form>