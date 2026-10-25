<?php
$data = $args['data'];
?>

<section data-module="foto">
    <header class="video-heading">
        <h1 class="video-title"><?= esc_html($data['title'] ?: 'Foto') ?></h1>
        <?php if (!empty($data['header_image']['src'])): ?>
            <img class="module-header-image" src="<?= esc_url($data['header_image']['src']) ?>" alt="<?= esc_attr($data['header_image']['alt'] ?? '') ?>">
        <?php endif; ?>
    </header>

    <?php if (!empty($data['photo_galleries'])): ?>
        <nav class="foto-gallery-menu" aria-label="Fotogalerien" data-foto-gallery-filter>
            <button type="button" data-gallery-filter="all" aria-pressed="true">Alle</button>
            <?php foreach ($data['photo_galleries'] as $index => $gallery): ?>
                <button type="button" data-gallery-filter="<?= esc_attr((string) $index) ?>" aria-pressed="false">
                    <?= esc_html($gallery['title']) ?>
                </button>
            <?php endforeach; ?>
        </nav>

        <?php
        $photo_images = [];
        foreach ($data['photo_galleries'] as $index => $gallery) {
            foreach ($gallery['images'] ?? [] as $image) {
                $photo_images[] = [
                    'image' => $image,
                    'gallery_index' => $index,
                    'gallery_title' => $gallery['title'],
                ];
            }
        }
        shuffle($photo_images);
        ?>
        <div class="video-gallery foto-gallery" data-foto-gallery-list>
            <?php foreach ($photo_images as $photo): ?>
                <?php if (!empty($photo['image']['src'])): ?>
                    <figure class="video-gallery-item" data-foto-gallery="<?= esc_attr((string) $photo['gallery_index']) ?>">
                        <img src="<?= esc_url($photo['image']['src']) ?>" alt="<?= esc_attr($photo['image']['alt'] ?? $photo['gallery_title']) ?>">
                    </figure>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($data['gallery']) || !empty($data['image']['src'])): ?>
        <div class="video-gallery" data-foto-gallery="legacy">
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
