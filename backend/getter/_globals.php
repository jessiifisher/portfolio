<?php

// todo: Hier die Getter für die Globalen Informationen definieren
function get_globals_logo(){
    $logo_id = carbon_get_theme_option('logo');
    $logo = get_media_by_id($logo_id);
    return $logo;
    js_log(content:$logo);
}

function get_globals_socials(){
    $socials = carbon_get_theme_option('socials');
    return array_map(callback: function($item){
        $item['icon'] = get_media_by_id($item['icon']);
        return $item;
    }, array: $socials);
    js_log(content: $socials);
}