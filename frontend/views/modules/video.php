<?php
$data = $args['data'];
?>

<section data-module="video">
    <header class="video-heading">
        <h1 class="video-title"><?= esc_html($data['title'] ?: 'Video') ?></h1>
        <span class="video-note" aria-hidden="true">cut!</span>
    </header>

    <?php if (!empty($data['projects'])): ?>
        <div class="video-gallery">
            <?php foreach ($data['projects'] as $project): ?>
                <?php
                $dialog_id = wp_unique_id('video-project-') . (int) $project['id'];
                $project_image = $project['image'] ?: [];
                ?>
                <article class="video-project">
                    <button class="video-project-open" type="button" data-project-open="<?= esc_attr($dialog_id) ?>" aria-haspopup="dialog">
                        <?php if (!empty($project_image['src'])): ?>
                            <img src="<?= esc_url($project_image['src']) ?>" alt="<?= esc_attr($project_image['alt'] ?? $project['title']) ?>">
                        <?php endif; ?>
                        <span class="video-project-title" aria-hidden="true"><?= esc_html($project['title']) ?></span>
                        <span class="screen-reader-text"><?= esc_html($project['title']) ?> ansehen</span>
                    </button>
                    <dialog class="video-project-dialog" id="<?= esc_attr($dialog_id) ?>" aria-labelledby="<?= esc_attr($dialog_id) ?>-title">
                        <button class="video-project-close" type="button" data-project-close aria-label="Projektfenster schließen">&times;</button>
                        <div class="video-project-content">
                            <?php if (!empty($project_image['src'])): ?>
                                <img class="video-project-image" src="<?= esc_url($project_image['src']) ?>" alt="<?= esc_attr($project_image['alt'] ?? $project['title']) ?>">
                            <?php endif; ?>
                            <div class="video-project-copy">
                                <h2 id="<?= esc_attr($dialog_id) ?>-title"><?= esc_html($project['title']) ?></h2>
                                <?php if (!empty($project['lead'])): ?>
                                    <p class="video-project-lead"><?= esc_html($project['lead']) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($project['description'])): ?>
                                    <p class="video-project-description"><?= esc_html($project['description']) ?></p>
                                <?php endif; ?>
                                <?php if (!empty($project['text'])): ?>
                                    <div class="video-project-text"><?= wpautop($project['text']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </dialog>
                </article>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($data['gallery'])): ?>
        <div class="video-gallery">
            <?php foreach ($data['gallery'] as $image): ?>
                <?php if (!empty($image['src'])): ?>
                    <figure class="video-gallery-item">
                        <img src="<?= esc_url($image['src']) ?>" alt="<?= esc_attr($image['alt'] ?? $data['title']) ?>">
                    </figure>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($data['video_url'])): ?>
        <div class="video-wrapper">
            <?php if (strpos($data['video_url'], 'youtube.com') !== false || strpos($data['video_url'], 'youtu.be') !== false): ?>
                <?php
                $youtube_url = $data['video_url'];
                parse_str(parse_url($youtube_url, PHP_URL_QUERY) ?? '', $query_params);
                $video_id = $query_params['v'] ?? null;
                if (!$video_id && preg_match('/youtu\.be\/([^?&]+)/', $youtube_url, $matches)) {
                    $video_id = $matches[1];
                }
                ?>
                <?php if ($video_id): ?>
                    <iframe src="https://www.youtube.com/embed/<?= esc_attr($video_id) ?>" title="<?= esc_attr($data['title']) ?>" allowfullscreen></iframe>
                <?php else: ?>
                    <a href="<?= esc_url($data['video_url']) ?>" target="_blank" rel="noopener noreferrer">Video ansehen</a>
                <?php endif; ?>
            <?php else: ?>
                <video controls src="<?= esc_url($data['video_url']) ?>"></video>
            <?php endif; ?>
        </div>
    <?php elseif (!empty($data['image']['src'])): ?>
        <div class="video-gallery video-gallery--single">
            <figure class="video-gallery-item">
                <img src="<?= esc_url($data['image']['src']) ?>" alt="<?= esc_attr($data['image']['alt'] ?? $data['title']) ?>">
            </figure>
        </div>
    <?php endif; ?>
</section>
