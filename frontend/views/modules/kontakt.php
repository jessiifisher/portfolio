<?php
$data = $args['data'];
?>

<section data-module="kontakt">
    <h1 class="title"><?= $data['title'] ?></h1>

    <?php if (!empty($data['subline'])): ?>
        <p class="subline"><?= $data['subline'] ?></p>
    <?php endif; ?>

    <?php if (!empty($data['content'])): ?>
        <div class="content"><?= nl2br($data['content']) ?></div>
    <?php endif; ?>

    <?php if (!empty($data['email'])): ?>
        <p><a href="mailto:<?= htmlspecialchars($data['email']) ?>"><?= htmlspecialchars($data['email']) ?></a></p>
    <?php endif; ?>

    <?php if (!empty($data['phone'])): ?>
        <p><a href="tel:<?= htmlspecialchars($data['phone']) ?>"><?= htmlspecialchars($data['phone']) ?></a></p>
    <?php endif; ?>
</section>
