<?php
$data = $args['data'];
?>

<section data-module="example">
    <img class="image" src="<?= $data['image']['src'] ?>" alt="<?= $data['image']['alt'] ?>">
    <?php if (!empty($data['image_secondary']['src'])): ?>
        <img class="image-secondary" src="<?= esc_url($data['image_secondary']['src']) ?>" alt="<?= esc_attr($data['image_secondary']['alt'] ?? '') ?>">
    <?php endif; ?>
    <?php if (!empty($data['subline_before'])): ?>
        <p class="subline subline-before"><?= esc_html($data['subline_before']) ?></p>
    <?php endif; ?>
    <h1 class="title"><?= $data['title'] ?></h1>
    <?php if (!empty($data['subline_after'])): ?>
        <p class="subline subline-after"><?= esc_html($data['subline_after']) ?></p>
    <?php endif; ?>
    <?php if (!empty($data['favorite_projects'])): ?>
        <a class="favorite-projects-arrow" href="#favorite-projects" aria-label="Zu den Lieblingsprojekten">
        <?php if (!empty($data['favorite_projects_arrow']['src'])): ?>
            <img src="<?= esc_url($data['favorite_projects_arrow']['src']) ?>" alt="">
        <?php else: ?>
            <span aria-hidden="true">↓</span>
        <?php endif; ?>
    </a>
    <?php endif; ?>
</section>

<?php if (!empty($data['favorite_projects'])): ?>
    <section id="favorite-projects" class="favorite-projects" data-section="favorite-projects" aria-label="Lieblingsprojekte">
        <div class="favorite-projects-gallery">
            <?php foreach ($data['favorite_projects'] as $project): ?>
                <?php $project_image = $project['image'] ?: []; ?>
                <?php if (!empty($project_image['src'])): ?>
                    <a class="favorite-project-card" href="<?= esc_url($project['url']) ?>" aria-label="<?= esc_attr($project['title']) ?>">
                        <img src="<?= esc_url($project_image['src']) ?>" alt="<?= esc_attr($project_image['alt'] ?? $project['title']) ?>">
                        <span class="favorite-project-name"><?= esc_html($project['title']) ?></span>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
