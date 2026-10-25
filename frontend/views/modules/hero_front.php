<?php
$data = $args['data'];
js_log(content: $data)
?>

<section data-module="hero_front">
    <h1 class="title"><?= $data['title'] ?></h1>
    <?php if ($data['subline']): ?>
    <p class="subline"><?= $data['subline'] ?></p>
    <?php endif; ?>
    <figure class="hero-front-image-wrap">
        <img class="hero-front-image" src="<?= esc_url($data['image']['src']) ?>" alt="<?= esc_attr($data['image']['alt'] ?? '') ?>">
        <?php if (!empty($data['image_secondary']['src'])): ?>
            <img class="hero-front-image-overlay" src="<?= esc_url($data['image_secondary']['src']) ?>" alt="<?= esc_attr($data['image_secondary']['alt'] ?? '') ?>">
        <?php endif; ?>
    </figure>
</section>
