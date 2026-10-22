<?php

function get_projekt_by_id(int $id): array{
    $title = get_the_title($id);
    $image_id = carbon_get_post_meta($id, 'image');
    $image = get_media_by_id(id:$image_id);
    $embed_url = carbon_get_post_meta($id, 'embed_url');
    $gallery_ids = carbon_get_post_meta($id, 'gallery');
    $gallery = array_filter(array_map(
        static fn ($image_id) => get_media_by_id($image_id, 'large'),
        $gallery_ids ?: []
    ));
    $lead = carbon_get_post_meta($id, 'lead');
    $description = carbon_get_post_meta($id, 'description');
    $text = carbon_get_post_meta($id, 'text');
    return[
        'title' => $title,
        'image' => $image,
        'embed_url' => $embed_url,
        'gallery' => $gallery,
        'lead' => $lead,
        'description' => $description,
        'text' => $text,
    ];
}
