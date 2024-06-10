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
    $yourApiKey = $_ENV["API_openai"];

    $client = OpenAi::client($yourApiKey);
    $url = "$url?auto=compress&cs=tinysrgb&dpr=1&fit=crop&h=200&w=280";
    // :

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

    $data = $result->choices[0]->message->content;

    // echo "<pre>",var_dump($data),"</pre>";

    $firstExplode = explode('```json', $data);
    if (count($firstExplode) == 2) {
        $result = explode('```', $firstExplode[1])[0];
    } else {
        echo "else";
        $result = $data;
    }


    try {
        $data = json_decode($result, false);
        var_dump($data);
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
        throw $th;
        $skeletonObject = new stdClass();
        $skeletonObject->title = 'Title';
        $skeletonObject->header = 'Header';
        $skeletonObject->description = 'Description';
        $skeletonObject->keywords = ['keyword'];
        $skeletonObject->url = $url;
        $data = $skeletonObject;
    }
    // echo "<pre>", var_dump($data), "</pre>";
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
                    <input type="text" name="title[<?= $key ?>]" value="<?= $value->title ?>">
                </div>
                <div class="div3 input-flex">

                    <label for="header">Header</label>
                    <input type="text" name="header[<?= $key ?>]" value="<?= $value->header ?>">
                </div>
                <div class="div4 input-flex">

                    <label for="description">Description</label>
                    <textarea name="description" id="description[<?= $key ?>]" value=""><?= $value->description ?></textarea>
                </div>
                <div class="div5 input-flex">

                    <label for="keywords">Keywords*</label>
                    <input type="text" name="keywords[<?= $key ?>]" value="<?= implode(', ', $value->keywords) ?>">
                    <p>*Comma separated</p>
                </div>
                <input type="hidden" name="url[<?= $key ?>]" value="<?= $_SESSION['ai'][$key] ?? "none" ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <input type="hidden" name="process" value="generation">
    <div class="input-flex button">
        <button type="submit">Validated</button>

    </div>
</form>