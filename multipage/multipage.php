<?php
include(dirname(__FILE__) . '/../incl/doctype.php');
?>
<article class="table-report report">
    <?php if ($page) : ?>
        <?php require $page["file"] ?>
    <?php else : ?>
        <p>you have selected a page reference '<?= htmlentities($pageReference) ?>' that does not map to an actual page.</p>
    <?php endif; ?>
</article>
<?php
include(dirname(__FILE__) . '/../incl/footer.php');
?>