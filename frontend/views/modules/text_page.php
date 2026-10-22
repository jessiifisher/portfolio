<?php
$data = $args['data'];
?>

<section data-module="text_page">
    <h1><?= esc_html($data['title']) ?></h1>
    <div class="text-page-content"><?= wpautop(esc_html($data['content'])) ?></div>
</section>
