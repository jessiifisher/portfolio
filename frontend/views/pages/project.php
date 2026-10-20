<?php
$project = get_projekt_by_id(id: get_the_ID());
?>

<main data-page="project">
    <p class="preline">Projekt</p>
    <h1 class="title"><?= $project['title'] ?> </h1>
    <img class="image" src="<?= $project['image']['src'] ?>" alt="<?= $project['image']['alt'] ?>">
    <p class="lead"><?= $project['lead']?></p>
    <div class="text">
        <?= wpautop($project['text']) ?>
    </div>
</main>