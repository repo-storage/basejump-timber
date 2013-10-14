<?php

/**
 * Timber theme functions file
 * @package Wordpress
 * @subpackage Theme
 * @since 0.1
 * @author Shawn Sandy <shawnsandy04@gmail.com>
 */





/**
 * twig functions
 */

add_filter('get_twig', 'add_to_twig');
add_filter('timber_context', 'add_to_context');

define('THEME_URL', get_template_directory_uri());

function add_to_context($data) {
    /* this is where you can add your own data to Timber's context object */
    $data['foo'] = 'bar';
    $data['theme_url'] = get_stylesheet_directory_uri();
    $data['is_logged_in'] = is_user_logged_in();
    $data['theme_mod'] = get_theme_mods();
    $data['site_url'] = site_url();
    $data['sidebar'] = Timber::get_widgets('sidebar-2');
    //pico variables converted for wordpress
    $data['config'] = get_theme_mods();
    return $data;
}

function add_to_twig($twig) {
    /* this is where you can add your own fuctions to twig */
    $twig->addExtension(new Twig_Extension_StringLoader());
    $twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
    return $twig;
}


function myfoo($text) {
    $text .= ' bar!';
    return $text;
}
