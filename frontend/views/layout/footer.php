<?php
$menu = get_menu_by_slug(slug:'legals');
$socials = get_globals_socials();
?>

<footer data-layout="footer">
    <a class="home-link" href="<?= esc_url(home_url('/')) ?>">jessi fisher ★ multimedia producer</a>
   <div class="socials">
       <?php foreach ($socials as $item): ?>
       <a target="_blank" href="<?= $item['link'] ?>" aria label="Link zu <?= $item['title'] ?>">
           <img src="<?= $item['icon']['src'] ?>" alt="<?= $item['icon']['alt'] ?>">
       </a>
       <?php endforeach; ?>
   </div>
    <nav class ="nav-container">
        <ul class=" nav">
            <?php foreach ($menu as $item): ?>
                <li class="nav-item">
                    <a target="<?= $item['target'] ?>" href="<?= $item['url'] ?>">
                        <?= $item['title'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</footer>
