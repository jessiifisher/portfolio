<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

// -> Konfiguration der verschiedenen Module
Container::make('post_meta', 'Module')
    ->where('post_type', '=', 'page')
    ->add_fields([
        Field::make('complex', 'modules', 'Module')
            // -> example
            ->add_fields('example', 'Beispiel', [
                Field::make('text', 'subline_before', 'Subline vor dem Titel'),
                Field::make('text', 'title', 'Titel'),
                Field::make('text', 'subline_after', 'Subline nach dem Titel'),
                Field::make('image', 'image', 'Bild')->set_required(),
                Field::make('image', 'image_secondary', 'Zweites Bild (rechts oben)'),
                Field::make('media_gallery', 'decorative_gifs', 'Dekorative GIFs'),
                Field::make('image', 'favorite_projects_arrow', 'Bild für den Pfeil zu den Lieblingsprojekten'),
                Field::make('association', 'favorite_projects', 'Lieblingsprojekte')
                    ->set_types([
                        [
                            'type' => 'post',
                            'post_type' => 'project',
                        ],
                    ]),
            ])
            // --> hero_front
            ->add_fields('hero_front', 'Hero Startseite', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('textarea', 'subline', 'Subline'),
                Field::make('image', 'image', 'Bild')->set_required(),
                Field::make('image', 'image_secondary', 'Zweites Bild über dem Bild (optional)'),
            ])
            // --> ueber_mich
            ->add_fields('ueber_mich', 'Über mich', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('image', 'title_gif', 'GIF statt Titel (optional)'),
                Field::make('textarea', 'subline', 'Untertitel'),
                Field::make('textarea', 'content', 'Text'),
                Field::make('image', 'image', 'Bild'),
                Field::make('image', 'image_overlay', 'Zweites Bild über dem Bild (optional)'),
                Field::make('media_gallery', 'about_gallery', 'Fotogalerie unter dem Text'),
            ])
            // --> video
            ->add_fields('video', 'Video', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('image', 'header_image', 'GIF oben rechts'),
                Field::make('association', 'projects', 'Projekte auswählen')
                    ->set_types([
                        [
                            'type' => 'post',
                            'post_type' => 'project',
                        ],
                    ]),
                Field::make('media_gallery', 'gallery', 'Zusätzliche Bilder (optional)'),
                Field::make('text', 'video_url', 'Video-URL oder Embed-Link'),
                Field::make('image', 'image', 'Vorschaubild'),
            ])
            // --> foto
            ->add_fields('foto', 'Foto', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('image', 'header_image', 'GIF oben rechts'),
                Field::make('textarea', 'subline', 'Untertitel'),
                Field::make('complex', 'photo_galleries', 'Fotogalerien')
                    ->add_fields([
                        Field::make('text', 'title', 'Galeriename')->set_required(),
                        Field::make('media_gallery', 'images', 'Fotos'),
                    ])
                    ->set_header_template('<% if (title) { %><%- title %><% } %>')
                    ->set_layout('tabbed-vertical'),
                Field::make('media_gallery', 'gallery', 'Fotogalerie'),
                Field::make('image', 'image', 'Bild'),
            ])
            // --> divers
            ->add_fields('divers', 'Divers', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('image', 'header_image', 'GIF oben rechts'),
                Field::make('textarea', 'subline', 'Untertitel'),
                Field::make('textarea', 'content', 'Text'),
                Field::make('image', 'image', 'Bild'),
                Field::make('association', 'projects', 'Projekte auswählen')
                    ->set_types([
                        [
                            'type' => 'post',
                            'post_type' => 'project',
                        ],
                    ]),
            ])
            // --> kontakt
            ->add_fields('kontakt', 'Kontakt', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('image', 'header_image', 'GIF oben rechts'),
                Field::make('media_gallery', 'decorative_gifs', 'Weitere GIFs auf der Seite'),
                Field::make('textarea', 'subline', 'Untertitel'),
                Field::make('text', 'email', 'E-Mail'),
                Field::make('text', 'phone', 'Telefon'),
                Field::make('textarea', 'content', 'Text'),
            ])
            ->add_fields('text_page', 'Textseite (z. B. Datenschutz / Impressum)', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('textarea', 'content', 'Text')->set_required(),
            ])
            // -> SETTINGS
            ->set_layout('tabbed-vertical')
    ]);

// -> Funktion, um die Module und die entsprechenden Templates auf der Seite zu laden
function render_modules (): void {
    $modules = carbon_get_the_post_meta('modules');
    if (empty($modules)) {
        return;
    }
    foreach ($modules as $module) {
        // -> Modifiziere die Daten des Moduls, falls nötig, basierend auf dem Modultyp
        switch ($module['_type']) {
            case 'example':
                if (!empty($module['image'])) {
                    $module['image'] = get_media_by_id($module['image'], 'full');
                }
                if (!empty($module['image_secondary'])) {
                    $module['image_secondary'] = get_media_by_id($module['image_secondary'], 'full');
                }
                $module['decorative_gifs'] = array_filter(array_map(
                    static fn ($image_id) => get_media_by_id($image_id, 'full'),
                    $module['decorative_gifs'] ?? []
                ));
                if (!empty($module['favorite_projects_arrow'])) {
                    $module['favorite_projects_arrow'] = get_media_by_id($module['favorite_projects_arrow'], 'full');
                }
                $module['favorite_projects'] = array_values(array_filter(array_map(
                    static function ($project_reference) {
                        $project_id = (int) ($project_reference['id'] ?? $project_reference);
                        if (
                            !$project_id
                            || get_post_type($project_id) !== 'project'
                            || get_post_status($project_id) !== 'publish'
                        ) {
                            return null;
                        }

                        $project = get_projekt_by_id($project_id);
                        $project['id'] = $project_id;
                        $project['url'] = get_permalink($project_id);
                        return $project;
                    },
                    $module['favorite_projects'] ?? []
                )));
                break;
            case 'hero_front':
                if (!empty($module['image'])) {
                    $module['image'] = get_media_by_id($module['image']);
                }
                if (!empty($module['image_secondary'])) {
                    $module['image_secondary'] = get_media_by_id($module['image_secondary']);
                }
                break;
            case 'ueber_mich':
                if (!empty($module['image'])) {
                    $module['image'] = get_media_by_id($module['image']);
                }
                if (!empty($module['image_overlay'])) {
                    $module['image_overlay'] = get_media_by_id($module['image_overlay']);
                }
                if (!empty($module['title_gif'])) {
                    $module['title_gif'] = get_media_by_id($module['title_gif'], 'full');
                }
                $module['about_gallery'] = array_filter(array_map(
                    static fn ($image_id) => get_media_by_id($image_id, 'large'),
                    $module['about_gallery'] ?? []
                ));
                break;
            case 'divers':
                if (!empty($module['header_image'])) {
                    $module['header_image'] = get_media_by_id($module['header_image'], 'full');
                }
                if (!empty($module['image'])) {
                    $module['image'] = get_media_by_id($module['image']);
                }
                $module['projects'] = array_values(array_filter(array_map(
                    static function ($project_reference) {
                        $project_id = (int) ($project_reference['id'] ?? $project_reference);
                        if (
                            !$project_id
                            || get_post_type($project_id) !== 'project'
                            || get_post_status($project_id) !== 'publish'
                        ) {
                            return null;
                        }

                        $project = get_projekt_by_id($project_id);
                        $project['id'] = $project_id;
                        $project['url'] = get_permalink($project_id);
                        return $project;
                    },
                    $module['projects'] ?? []
                )));
                break;
            case 'foto':
                if (!empty($module['header_image'])) {
                    $module['header_image'] = get_media_by_id($module['header_image'], 'full');
                }
                $module['photo_galleries'] = array_values(array_filter(array_map(
                    static function ($gallery) {
                        $images = array_values(array_filter(array_map(
                            static fn ($image_id) => get_media_by_id($image_id, 'large'),
                            $gallery['images'] ?? []
                        )));

                        if (empty($gallery['title']) || empty($images)) {
                            return null;
                        }

                        return [
                            'title' => $gallery['title'],
                            'images' => $images,
                        ];
                    },
                    $module['photo_galleries'] ?? []
                )));
                if (!empty($module['image'])) {
                    $module['image'] = get_media_by_id($module['image'], 'large');
                }
                $module['gallery'] = array_filter(array_map(
                    static fn ($image_id) => get_media_by_id($image_id, 'large'),
                    $module['gallery'] ?? []
                ));
                break;
            case 'video':
                if (!empty($module['header_image'])) {
                    $module['header_image'] = get_media_by_id($module['header_image'], 'full');
                }
                if (!empty($module['image'])) {
                    $module['image'] = get_media_by_id($module['image']);
                }
                $module['projects'] = array_values(array_filter(array_map(
                    static function ($project_reference) {
                        $project_id = (int) ($project_reference['id'] ?? $project_reference);
                        if (
                            !$project_id
                            || get_post_type($project_id) !== 'project'
                            || get_post_status($project_id) !== 'publish'
                        ) {
                            return null;
                        }

                        $project = get_projekt_by_id($project_id);
                        $project['id'] = $project_id;
                        $project['url'] = get_permalink($project_id);
                        return $project;
                    },
                    $module['projects'] ?? []
                )));
                $module['gallery'] = array_filter(array_map(
                    static fn ($image_id) => get_media_by_id($image_id, 'large'),
                    $module['gallery'] ?? []
                ));
                break;
            case 'kontakt':
                if (!empty($module['header_image'])) {
                    $module['header_image'] = get_media_by_id($module['header_image'], 'full');
                }
                $module['decorative_gifs'] = array_filter(array_map(
                    static fn ($image_id) => get_media_by_id($image_id, 'full'),
                    $module['decorative_gifs'] ?? []
                ));
                break;
            // todo: add data modifications for modules here as a new case
        }
        // -> Laden des Templates basierend auf dem Modultyp und weitergeben der Daten
        get_template_part(
            'frontend/views/modules/' . $module['_type'],
            null,
            [
                'data' => $module
            ]
        );
    }
}
