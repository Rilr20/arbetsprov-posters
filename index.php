<?php
include './config.php';
include './incl/doctype.php';
include './incl/header.php';
$posters = [];
$pdo = new PDO($_ENV['mysql_dsn'], $_ENV['mysql_username'], $_ENV['mysql_password']);
$stmt = $pdo->query("SELECT p.id, p.description, p.title, p.header, p.thumbnail, GROUP_CONCAT(k.keyword SEPARATOR ', ') AS keywords FROM posters AS p JOIN poster_to_keywords AS pt ON p.id = pt.poster_id JOIN keywords AS k ON pt.keyword_id = k.id GROUP BY p.id;");
// $stmt->execute();
$posters = $stmt->fetchAll();
// echo "<pre>",var_dump($posters),"</pre>";
?>
<main>
    <h1 class="title">Posters</h1>
    <div class="posters">
        <?php foreach ($posters as $poster) : ?>
            <div class="poster">
                <h2 class="poster-title"><a href="image.php?id=<?= $poster["id"] ?> "><?= $poster["title"] ?></a></h2>
                <div class="poster-img">
                    <img src="data:image/jpeg;base64,<?= base64_encode($poster['thumbnail']); ?>" alt="<?= $poster["title"] ?>">
                </div>
                <h3 class="poster-header"><?= $poster["header"] ?></h3>
                <p class="poster-description"><?= $poster["description"] ?></p>
                <div class="poster-keyword">
                    <?php foreach (explode(", ", $poster['keywords']) as $keyword) : ?>
                        <p class="poster-keyword-text"><?= $keyword ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php
include './incl/footer.php';
