<?php
include './config.php';
include './incl/doctype.php';
include './incl/header.php';
$poster = [];
$pdo = new PDO($_ENV['mysql_dsn'], $_ENV['mysql_username'], $_ENV['mysql_password']);
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT p.id, p.description, p.title, p.header, p.image, GROUP_CONCAT(k.keyword SEPARATOR ', ') AS keywords FROM posters AS p JOIN poster_to_keywords AS pt ON p.id = pt.poster_id JOIN keywords AS k ON pt.keyword_id = k.id WHERE p.id = ? GROUP BY p.id;");
$stmt->execute([$id]);
$poster = $stmt->fetch();
?>
<main>
    <h1 class="title">Poster</h1>
    <h2 class="title"><?= $poster["title"] ?></h2>
    <p><a href="index.php">Index</a> Go Back to Index</p>
    <div class="large-poster">
        <div class="large-poster-img">
            <img src="data:image/jpeg;base64,<?= base64_encode($poster['image']); ?>" alt="<?= $poster["title"] ?>">
        </div>
        <h3 class="large-poster-header"><?= $poster["header"] ?></h3>
        <p class="large-poster-description"><?= $poster["description"] ?></p>
        <div class="large-poster-keyword">
            <?php foreach (explode(", ", $poster['keywords']) as $keyword) : ?>
                <p class="poster-keyword-text"><?= $keyword ?></p>
            <?php endforeach; ?>
        </div>
</main>

<?php
include './incl/footer.php';
