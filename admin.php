<?php
if (true) {
}

// search for image
$curl = curl_init();
$header = array();
$search = "nature";
// $header[] = 'Authorization: xxjCiUcIHYdK5dqtEeqbJpf3b2dUmGrZLoi0ai4ueO9Nfkeoggmn6uB1';
curl_setopt($curl, CURLOPT_URL, "https://api.pexels.com/v1/search?query=" . urlencode($search) . "&per_page=4");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPGET, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    "Authorization: xxjCiUcIHYdK5dqtEeqbJpf3b2dUmGrZLoi0ai4ueO9Nfkeoggmn6uB1"
));
$result = curl_exec($curl);
curl_close($curl);
// print_r($result);
$data = json_decode($result);
var_dump($data->photos[0]);
// echo "<br>";
var_dump("");
var_dump($data->photos);

// var_dump($result);

// "Authorization: xxjCiUcIHYdK5dqtEeqbJpf3b2dUmGrZLoi0ai4ueO9Nfkeoggmn6uB1" \"https://api.pexels.com/v1/search?query=nature&per_page=1"

?>
<h1>Admin Page</h1>
