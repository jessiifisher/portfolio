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
                $project_image = $project['image'] ?: [];
                ?>
                <article class="video-project">
                    <a class="video-project-link" href="<?= esc_url($project['url']) ?>" aria-label="<?= esc_attr($project['title']) ?>">
                        <?php if (!empty($project_image['src'])): ?>
                            <img src="<?= esc_url($project_image['src']) ?>" alt="<?= esc_attr($project_image['alt'] ?? $project['title']) ?>">
                        <?php endif; ?>
                        <span class="video-project-title" aria-hidden="true"><?= esc_html($project['title']) ?></span>
                    </a>
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
