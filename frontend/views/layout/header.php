<?php
$menu = get_menu_by_slug(slug:'main');
?>

<header data-layout="header">
    <a class="home-link" href="<?= esc_url(home_url('/')) ?>">jessi fisher ★ multimedia producer</a>
    <nav class ="nav-container">
        <ul class=" nav">
            <?php foreach ($menu as $item): ?>
                <?php if (strtolower(trim($item['title'])) === 'startseite') continue; ?>
                <li class="nav-item">
                    <a
                        target="<?= esc_attr($item['target']) ?>"
                        href="<?= esc_url($item['url']) ?>"
                        <?= (int) $item['ID'] === (int) get_queried_object_id() ? 'aria-current="page"' : '' ?>
                    >
                        <?= $item['title'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</header>
