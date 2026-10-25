<?php
$data = $args['data'];
?>

<section data-module="ueber_mich">
    <div class="about-layout">
        <?php if (!empty($data['image']['src'])): ?>
            <figure class="about-image-wrap">
                <img class="about-image" src="<?= esc_url($data['image']['src']) ?>" alt="<?= esc_attr($data['image']['alt'] ?? $data['title']) ?>">
                <?php if (!empty($data['image_overlay']['src'])): ?>
                    <img class="about-image-overlay" src="<?= esc_url($data['image_overlay']['src']) ?>" alt="<?= esc_attr($data['image_overlay']['alt'] ?? '') ?>">
                <?php endif; ?>
            </figure>
        <?php endif; ?>

        <div class="about-copy">
            <?php if (!empty($data['title_gif']['src'])): ?>
                <h1 class="about-title about-title--gif">
                    <img class="about-title-gif" src="<?= esc_url($data['title_gif']['src']) ?>" alt="<?= esc_attr($data['title']) ?>">
                </h1>
            <?php else: ?>
                <h1 class="about-title"><?= esc_html($data['title']) ?></h1>
            <?php endif; ?>

            <?php if (!empty($data['subline'])): ?>
                <p class="about-subline"><?= esc_html($data['subline']) ?></p>
            <?php endif; ?>

            <?php if (!empty($data['content'])): ?>
                <div class="about-content"><?= nl2br(esc_html($data['content'])) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($data['about_gallery'])): ?>
        <div class="about-gallery">
            <?php foreach ($data['about_gallery'] as $image): ?>
                <?php if (!empty($image['src'])): ?>
                    <figure class="about-gallery-item">
                        <img src="<?= esc_url($image['src']) ?>" alt="<?= esc_attr($image['alt'] ?? '') ?>">
                    </figure>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
