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
    $data['options'] = wp_load_alloptions();
    $data['site_url'] = site_url();
    $data['sidebar'] = Timber::get_widgets('sidebar-2');
    $data['is_home'] = is_home();
    //pico theme variables converted to wordpress
    $data['config'] = get_theme_mods();
    $data['base_dir'] = WP_CONTENT_DIR;
    $data['base_url'] = get_bloginfo('wpurl');
    $data['theme_dir'] = get_stylesheet_directory();
    $data['site_title'] = get_bloginfo('name');
    $data['meta'] = '';
    $data['pages'] = '';
    $data['is_front_page'] = is_front_page();
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
