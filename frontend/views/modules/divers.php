<?php
$data = $args['data'];
?>

<section data-module="divers">
    <header class="video-heading">
        <h1 class="video-title"><?= esc_html($data['title'] ?: 'Divers') ?></h1>
        <?php if (!empty($data['header_image']['src'])): ?>
            <img class="module-header-image" src="<?= esc_url($data['header_image']['src']) ?>" alt="<?= esc_attr($data['header_image']['alt'] ?? '') ?>">
        <?php endif; ?>
    </header>

    <?php if (!empty($data['image']['src']) || !empty($data['subline']) || !empty($data['content'])): ?>
        <div class="divers-content">
            <?php if (!empty($data['image']['src'])): ?>
                <img class="divers-image" src="<?= esc_url($data['image']['src']) ?>" alt="<?= esc_attr($data['image']['alt'] ?? $data['title']) ?>">
            <?php endif; ?>

            <div class="divers-copy">
                <?php if (!empty($data['subline'])): ?>
                    <p class="divers-subline"><?= esc_html($data['subline']) ?></p>
                <?php endif; ?>

                <?php if (!empty($data['content'])): ?>
                    <div class="divers-text"><?= nl2br(esc_html($data['content'])) ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($data['projects'])): ?>
        <div class="video-gallery divers-projects">
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
    <?php endif; ?>
</section>
