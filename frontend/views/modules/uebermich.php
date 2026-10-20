<?php
$data = $args['data'];
js_log(content: $data)
?>

<section data-module="hero_front">
    <h1 class="title"><?= $data['title'] ?></h1>
    <?php if ($data['subline']): ?>
        <p class="subline"><?= $data['subline'] ?></p>
    <?php endif; ?>
    <img src="image" src="<?= $data['image']['src'] ?>" alt="<?= $data['image']['alt'] ?>">
</section>