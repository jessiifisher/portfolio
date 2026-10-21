<?php
$data = $args['data'];
?>

<section data-module="ueber_mich">
    <div class="about-layout">
        <?php if (!empty($data['image']['src'])): ?>
            <figure class="about-image-wrap">
                <img class="about-image" src="<?= esc_url($data['image']['src']) ?>" alt="<?= esc_attr($data['image']['alt'] ?? $data['title']) ?>">
                <span class="about-image-note" aria-hidden="true">nice!</span>
            </figure>
        <?php endif; ?>

        <div class="about-copy">
            <h1 class="about-title"><?= esc_html($data['title']) ?></h1>

            <?php if (!empty($data['subline'])): ?>
                <p class="about-subline"><?= esc_html($data['subline']) ?></p>
            <?php endif; ?>

            <?php if (!empty($data['content'])): ?>
                <div class="about-content"><?= nl2br(esc_html($data['content'])) ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>
