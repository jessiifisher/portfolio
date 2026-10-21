<?php
$data = $args['data'];
?>

<section data-module="foto">
    <header class="video-heading">
        <h1 class="video-title"><?= esc_html($data['title'] ?: 'Foto') ?></h1>
        <span class="video-note" aria-hidden="true">click!</span>
    </header>

    <?php if (!empty($data['gallery']) || !empty($data['image']['src'])): ?>
        <div class="video-gallery">
            <?php if (!empty($data['gallery'])): ?>
                <?php foreach ($data['gallery'] as $image): ?>
                    <?php if (!empty($image['src'])): ?>
                        <figure class="video-gallery-item">
                            <img src="<?= esc_url($image['src']) ?>" alt="<?= esc_attr($image['alt'] ?? $data['title']) ?>">
                        </figure>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <figure class="video-gallery-item">
                    <img src="<?= esc_url($data['image']['src']) ?>" alt="<?= esc_attr($data['image']['alt'] ?? $data['title']) ?>">
                </figure>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
