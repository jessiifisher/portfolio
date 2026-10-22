<?php
$project = get_projekt_by_id(id: get_the_ID());
?>

<main data-page="project">
    <header class="project-heading">
        <p class="project-kicker">Projekt</p>
        <h1 class="project-title"><?= esc_html($project['title']) ?></h1>
    </header>

    <?php if (!empty($project['embed_url'])): ?>
        <?php
        $embed_url = esc_url($project['embed_url']);
        $video_extension = strtolower(pathinfo((string) parse_url($embed_url, PHP_URL_PATH), PATHINFO_EXTENSION));
        $is_direct_video = in_array($video_extension, ['mp4', 'webm', 'ogg'], true);
        $embedded_video = $is_direct_video ? false : wp_oembed_get($embed_url);
        ?>
        <div class="project-embed">
            <?php if ($is_direct_video): ?>
                <video controls src="<?= $embed_url ?>" title="<?= esc_attr($project['title']) ?>"></video>
            <?php elseif ($embedded_video): ?>
                <?= $embedded_video ?>
            <?php else: ?>
                <p>Dieses Video kann nicht eingebettet werden. <a href="<?= $embed_url ?>" target="_blank" rel="noopener noreferrer">Video ansehen</a></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($project['gallery'])): ?>
        <section class="project-carousel" data-project-carousel aria-label="Bildergalerie: <?= esc_attr($project['title']) ?>">
            <div class="project-carousel-track">
                <?php foreach ($project['gallery'] as $index => $image): ?>
                    <?php if (!empty($image['src'])): ?>
                        <figure class="project-carousel-slide">
                            <img src="<?= esc_url($image['src']) ?>" alt="<?= esc_attr($image['alt'] ?? ($project['title'] . ' – Bild ' . ($index + 1))) ?>">
                        </figure>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php if (count($project['gallery']) > 1): ?>
                <div class="project-carousel-controls">
                    <button type="button" data-carousel-direction="-1" aria-label="Vorheriges Bild">←</button>
                    <button type="button" data-carousel-direction="1" aria-label="Nächstes Bild">→</button>
                </div>
            <?php endif; ?>
        </section>
    <?php endif; ?>

    <div class="project-copy">
        <?php if (!empty($project['lead'])): ?>
            <div class="project-lead"><?= wpautop(esc_html($project['lead'])) ?></div>
        <?php endif; ?>
        <?php if (!empty($project['text'])): ?>
            <div class="project-text"><?= wpautop($project['text']) ?></div>
        <?php endif; ?>
        <a class="project-back" href="<?= esc_url(wp_get_referer() ?: home_url('/')) ?>">← Zurück</a>
    </div>
</main>