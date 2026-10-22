<?php
$data = $args['data'];
$socials = get_globals_socials();
?>

<section data-module="kontakt">
    <header class="contact-heading">
        <h1 class="contact-title"><?= esc_html($data['title'] ?: 'Contact') ?></h1>
        <span class="contact-spark contact-spark--top" aria-hidden="true">✳</span>
        <span class="contact-spark contact-spark--side" aria-hidden="true">✳</span>
        <span class="contact-doodle contact-doodle--top" aria-hidden="true">〰</span>
    </header>

    <div class="contact-details">
        <div class="contact-primary">
            <p class="contact-intro"><?= esc_html($data['subline'] ?: 'Have a project, a half-formed idea or just want to say hello?') ?></p>
            <?php if (!empty($data['email'])): ?>
                <a class="contact-email" href="mailto:<?= esc_attr($data['email']) ?>"><?= esc_html($data['email']) ?></a>
            <?php endif; ?>
            <?php if (!empty($data['content'])): ?>
                <div class="contact-copy"><?= nl2br(esc_html($data['content'])) ?></div>
            <?php endif; ?>
            <?php if (!empty($data['phone'])): ?>
                <a class="contact-phone" href="tel:<?= esc_attr($data['phone']) ?>"><?= esc_html($data['phone']) ?></a>
            <?php endif; ?>
        </div>

        <nav class="contact-socials" aria-label="Social media and contact links">
            <?php foreach ($socials as $item): ?>
                <a href="<?= esc_url($item['link']) ?>" target="_blank" rel="noopener noreferrer">
                    <?= esc_html($item['title']) ?> <span aria-hidden="true">↗</span>
                </a>
            <?php endforeach; ?>
            <?php if (!empty($data['email'])): ?>
                <a href="mailto:<?= esc_attr($data['email']) ?>">Email <span aria-hidden="true">↗</span></a>
            <?php endif; ?>
        </nav>
        <span class="contact-doodle contact-doodle--bottom" aria-hidden="true">✳ 〰</span>
    </div>
</section>
