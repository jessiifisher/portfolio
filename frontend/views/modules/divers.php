<?php
$data = $args['data'];
?>

<section data-module="divers">
    <header class="video-heading">
        <h1 class="video-title"><?= esc_html($data['title'] ?: 'Divers') ?></h1>
        <span class="video-note" aria-hidden="true">misc!</span>
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
                $dialog_id = wp_unique_id('divers-project-') . (int) $project['id'];
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
    <?php endif; ?>
</section>
