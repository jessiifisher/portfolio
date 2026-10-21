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
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('image', 'image', 'Bild')->set_required(),
            ])
            // --> hero_front
            ->add_fields('hero_front', 'Hero Startseite', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('textarea', 'subline', 'Subline'),
                Field::make('image', 'image', 'Bild')->set_required(),
            ])
            // --> ueber_mich
            ->add_fields('ueber_mich', 'Über mich', [
                Field::make('text', 'title', 'Titel')->set_required(),
                Field::make('textarea', 'subline', 'Untertitel'),
                Field::make('textarea', 'content', 'Text'),
                Field::make('image', 'image', 'Bild'),
            ])
            // --> video
            ->add_fields('video', 'Video', [
                Field::make('text', 'title', 'Titel')->set_required(),
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
                Field::make('textarea', 'subline', 'Untertitel'),
                Field::make('media_gallery', 'gallery', 'Fotogalerie'),
                Field::make('image', 'image', 'Bild'),
            ])
            // --> divers
            ->add_fields('divers', 'Divers', [
                Field::make('text', 'title', 'Titel')->set_required(),
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
                Field::make('textarea', 'subline', 'Untertitel'),
                Field::make('text', 'email', 'E-Mail'),
                Field::make('text', 'phone', 'Telefon'),
                Field::make('textarea', 'content', 'Text'),
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
                $module['image'] = get_media_by_id($module['image'], 'full');
                break;
            case 'hero_front':
            case 'ueber_mich':
                if (!empty($module['image'])) {
                    $module['image'] = get_media_by_id($module['image']);
                }
                break;
            case 'divers':
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
                        return $project;
                    },
                    $module['projects'] ?? []
                )));
                break;
            case 'foto':
                if (!empty($module['image'])) {
                    $module['image'] = get_media_by_id($module['image'], 'large');
                }
                $module['gallery'] = array_filter(array_map(
                    static fn ($image_id) => get_media_by_id($image_id, 'large'),
                    $module['gallery'] ?? []
                ));
                break;
            case 'video':
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
                        return $project;
                    },
                    $module['projects'] ?? []
                )));
                $module['gallery'] = array_filter(array_map(
                    static fn ($image_id) => get_media_by_id($image_id, 'large'),
                    $module['gallery'] ?? []
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
