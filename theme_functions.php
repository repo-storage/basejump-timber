<?php

/**
 * *****************************************************************************
 * THEME (DE)ACTIVATION
 * Theme activation hook: 'after_switch_theme'
 * Theme de-activation hook: 'switch_theme'
 */
/**
 * enqueue scripts
 *
 */
add_action('wp_enqueue_scripts', 'bj_theme_scripts');

function bj_theme_scripts() {
    /**
     * @todo add theme scripts here
     */
    wp_enqueue_script('scroll-top');
    wp_enqueue_script('scroll-to');
    wp_enqueue_script('local-scroll');

    wp_enqueue_script('pretty-photo');
    wp_enqueue_style('pretty-photo-css');
    wp_enqueue_script('fixie');
    //wp_enqueue_script('midway');

    wp_register_script('waypoints', cwp::locate_in_library('waypoints.js', 'js'), array('jquery'), null, TRUE);
    wp_enqueue_script('waypoints');

    wp_register_script('sticky', cwp::locate_in_library('jquery.sticky.js', 'js/sticky-master'), array('jquery'), null, TRUE);
    wp_enqueue_script('sticky');
    //wp_enqueue_script('theme-js');

//    wp_enqueue_script('unslider');
//    wp_enqueue_script('wp-unslider');

    wp_enqueue_script('nivo');
    wp_enqueue_script('nivo-config');
    wp_enqueue_style('nivo-default');

    // wp_enqueue_script('collage');

    if (Theme_Function::mobile_detect()->isMobile())
        wp_enqueue_script('doubletaptogo');
}

/**
 * theme deactivation
 * set theme name here
 */
add_action('switch_theme', 'bj_deactivate_theme');

function bj_deactivate_theme() {
    //name of your theme
    //update_option('cwp_last_theme', 'BJMUD');
}

/**
 * theme activation
 */
add_action('after_switch_theme', 'bj_activate_theme');

function bj_activate_theme() {

    //resets the home page to wordpress default (posts);

    Theme_Setup_Pages::factory()->setup();

    //FN_Setup_Menus::factory()->add_menu();
    Theme_Setup_Menus::factory()->add_pages();

    //**** change the default images sizes *******//
    //thumbnail_crop: Whether to crop the thumbnail to exact dimensions.

    update_option('medium_size_w', 760);
    update_option('medium_size_h', 0);

    //update size large images
    update_option('large_size_w', 1200);
    update_option('large_size_h', 800);

    custom_dp_dashboard();
}

/**
 * ******************************ADMIN INIT**************************************
 */
add_action('admin_init', 'bj_admin_init');

function bj_admin_init() {

}

/**
 * ******************************************************************************
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function cwp_theme_images($sizes) {
    $isizes = array(
        "theme-thumbnail" => __('Theme Thumbnails', 'basejump'),
        "theme-medium" => __('Theme Medium', 'basejump'),
    );
    $imgs = array_merge($sizes, $isizes);
    return $imgs;
}

add_action('after_setup_theme', 'bj_theme_setup');

function bj_theme_setup() {

    //setup the template directory

   // Tpl_Layout::set_bj_tpl_directory('tpl');

    /*
     * *********** Custom images sizes and post media manage integration ************
     */


    set_post_thumbnail_size(560, 380, TRUE);
    add_image_size('theme-340', 340, 230, true);
    add_image_size('theme-thumbnail', 560, 380, true);
    add_image_size('theme-medium', 780, 420, true);
    add_filter('image_size_names_choose', 'cwp_theme_images');

    //FN_Setup_Menus::set_menu_location();
    Theme_Setup_Menus::set_menu_location();
    //setup default menus
    Theme_Setup_Menus::factory()->add_pages();
    //FN_Setup_Menus::factory()->add_menu();

    /**
     * Theme menus
     */
    register_nav_menu('browse', __('Browse', 'basejump'));
    register_nav_menu('category', __('Categories', 'basejump'));
    register_nav_menu('about', __('About', 'basejump'));



    /**
     * adds all post functions
     */
    add_theme_support('post-formats', array('aside', 'gallery', 'video', 'link', 'image', 'quote', 'status'));

    add_theme_support('post-thumbnails');

    /*
     * add thumbnails to editior list
     */
    //core_admin::post_list_thumbs();
    Admin_Functions::post_list_thumbs();

    /** dp admin customisation */
    custom_dp_dashboard();
}

/*
 * Theme widgets
 */

add_action('widgets_init', 'bj_widgets');

function bj_widgets() {
    cwp::add_widget('info 1', 'info-1', 'Display widgets in the first footer box');
    cwp::add_widget('info 2', 'info-2', 'Display widgets in the second footer box');
    cwp::add_widget('info 3', 'info-3', 'Display widgets in the third footer box');
    cwp::add_widget('info 4', 'info-4', 'Display widgets in the fourth footer box');
    cwp::add_widget('home sidebar', 'home-sidebar', 'Display widgets on the Home page sidebar');
    //cwp::add_widget('info 5', 'info-5', 'Display widgets in the fifth footer box');
    //cwp::add_widget('Widget Page', 'widget-page', 'Display widgets on the widget-page tpl');
    //cwp::register_sidebar('404 Page', '404-page', 'Display widgets on the 404-page tpl');
}

/**
 * enqueue scripts
 */
add_action('wp_enqueue_scripts', 'cwpt_scripts');

function cwpt_scripts() {
    /**
     * @todo add theme scripts here
     */
    //wp_enqueue_script( 'script_name' );
    wp_enqueue_script('theme-js');
}

/**
 * ************Theme Content****************************************************
 */
/**
 * Layout Content (post type)
 * Use wordpress to create / define content for your themes layout sections
 * searchable false
 */
Tpl_Content::factory()->set_post_type('layout')->set_post_type_name('Theme Content')->create_options();


/**
 * *************customisations**************************************************
 */
//add more optoion to user profile
//cwp_social::contact_info();
Theme_Function::add_contact_info();

//post gallery rotator checkbox
//cwp_gallery::gallery_rotator();

core_admin::remove_wp_adminbar_logo();


/**
 * ***********grab browser screenshots shortcode********************************
 */
//cwp::browsershots();
Theme_Function::browser_shots();

/**
 * display gallery metabox image gallery metabox
 */
if (function_exists('be_gallery_metabox')):

    function be_gallery_types() {
        $post = array('post', 'page', 'cwp_theme');
        return $post;
    }

    function be_gallery_icon() {
        return 'icon-60';
    }

    add_filter('be_gallery_metabox_post_types', 'be_gallery_types', 10, 2);
    add_filter('be_gallery_metabox_image_size', 'be_gallery_icon', 10, 2);

endif;

/**
 * remove dashboard widgets
 */
//core_admin::remove_dashboard_widgets();

/**
 * remove post revisions
 */
add_action('init', 'cwpt_custom_init');

function cwpt_custom_init() {
    remove_post_type_support('post', 'revisions');
}

/**
 * --- AL-Manager -----
 */
add_filter('alm_filter', 'al_paths');

//sample fliter adds 'inc' dir to the autoload paths
//used for development scripts
function al_paths($folders) {
    $p = array(WP_PLUGIN_DIR . '/al-manager/inc/');
    $folders = array_merge($p, $folders);
    return $folders;
}

//check if ALM is loaded and add filter
add_filter('alm_filter', 'al_paths_');

//sample fliter adds 'inc' dir to the autoload paths
//used for development scripts
function al_paths_($folders) {
    $p = array(WP_PLUGIN_DIR . '/al-manager/library/');
    $folders = array_merge($p, $folders);
    return $folders;
}


/**
 * Phone body class
 */
if (mod_mobile::detect()->isPhone())
    add_filter('body_class', 'cwpt_phone_class');

function cwpt_phone_class($classes) {
    $classes[] = 'phone';
    return $classes;
}

/**
 * Editor style
 */
add_editor_style('editor-style.css');

Fn_Images::image_figure();

function link_excerpt_more($more) {
    global $post;
    return '<span class="readon-link"> <a href="' . get_permalink($post->ID) . '">' . __('Full Story', 'basejump') . '  </a></span> ';
}

add_filter('excerpt_more', 'link_excerpt_more');


/**
 * AL.Manager - make sure you are cleared to run, load classes on init do not load directly;
 */
add_action('init', 'load_classes');

function load_classes() {

//MB_Img_url::add_metabox()->admin_actions()->set_metabox_id('my-metabox');
    $styles = array(
        array('title' => 'Buttons'),
        array('title' => 'Button', 'inline' => 'span', 'classes' => 'btn'),
        array('title' => 'Info', 'inline' => 'span', 'classes' => 'btn btn-info'),
        array('title' => 'Success', 'inline' => 'span', 'classes' => 'btn btn-success'),
        array('title' => 'Warning', 'inline' => 'span', 'classes' => 'btn btn-warning'),
        array('title' => 'Pragraphs Styles'),
        array('title' => 'Lead', 'block' => 'p', 'classes' => 'lead'),
        array('title' => 'Muted', 'block' => 'p', 'classes' => 'muted'),
        array('title' => 'Warning', 'block' => 'p', 'classes' => 'text-warning'),
        array('title' => 'Error', 'block' => 'p', 'classes' => 'text-error'),
        array('title' => 'Info', 'block' => 'p', 'classes' => 'text-info'),
        array('title' => 'Success', 'block' => 'p', 'classes' => 'text-success'),
        array('title' => 'Labels'),
        array('title' => 'Default', 'inline' => 'span', 'classes' => 'label'),
        array('title' => 'Warning', 'inline' => 'span', 'classes' => 'label label-warning'),
        array('title' => 'Info', 'inline' => 'span', 'classes' => 'label label-info'),
        array('title' => 'Important', 'inline' => 'span', 'classes' => 'label label-important'),
        array('title' => 'Alerts'),
        array('title' => 'Default', 'block' => 'div', 'classes' => 'alert'),
        array('title' => 'Info', 'block' => 'div', 'classes' => 'alert alert-info'),
        array('title' => 'Error', 'block' => 'div', 'classes' => 'alert alert-error'),
        array('title' => 'Success', 'block' => 'div', 'classes' => 'alert alert-success'),
        array('title' => 'Others'),
        array('title' => 'Well', 'block' => 'div', 'classes' => 'well'),
        array('title' => 'Highlight', 'inline' => 'span', 'classes' => 'highlight'),
    );

    Ext_Editor_Styles::create()->set_styles($styles)->add_filters();

    /**
     * Theme Navs
     */
    /** Adss amenu item * */
    Ext_WPNavs::add()->set_theme_location('primary')->add_loginout();

    /**
     * remove img widh and height
     */
    Fn_Images::factory()->fluid_images();

    //****************load classses ********************************************
}

/**
 * *****************************************************************************
 * Customize Adminbar Post Menus
 * *****************************************************************************
 */
function apm_menus() {

    //create an post_type array(post_type, menu_title);
    $post_types = array('post' => 'Posts', 'page' => 'Pages', 'download' => 'Download', 'cwp_faq' => "FAQ(s)");

    //load and run the class
    $apmmenus = AdminbarPostMenus::add_menus()->set_list_count(5)->set_post_types($post_types)->nodes();
}

if (class_exists('AdminbarPostMenus'))
    add_action('init', 'apm_menus');


/**
 * *****************************************************************************
 * Theme Customizer
 * *****************************************************************************
 */
//bj_customizer::factory();
//Customizer_Setup::factory();

Basejump_Theme_Options::factory()->setup();

Basejump_Theme_Options::slugs();

Basejump_Theme_Options::contacts();

Basejump_Theme_Options::settings();

//bjc_contact::factory();
//moved to layout content
//bjc_copy_editor::factory();
//******************************************************************************

/**
 * Add PHP.Views widget
 */
$tpl_widget = new Tpl_Widget();
/**
 * Add contact widget
 */
BJ_Contact_Widget::register_widget();
/**
 * Add HTML Content widget
 */
BJ_MCE_Editor::register_widget();

/**
 * REcent thumbs
 */
//Recent_thumbs_Widget::register_widget();

/**
 * *****************************************************************************
 * BaseJump Shortcodes
 * *****************************************************************************
 */
$bj_shortcodes = BJ_Shortcodes::add();

$bj_shortcodes->shortcode('fixie', 'fixie');

//******************************************************************************

BJ::default_post_thumbanils();

/**
 * Change / replace post editor(s) place holder titles
 */
Replace_Editor_Title::replace();

Widgets_AdvancedPost::register_widget();

Widgets_PostThumb::register_widget();

//add_action( 'pre_get_posts', 'be_exclude_category_from_blog' );
/**
 * Exclude Category from Blog
 *
 * @author Bill Erickson
 * @link http://www.billerickson.net/customize-the-wordpress-query/
 * @param object $query data
 *
 */
function be_exclude_category_from_blog($query) {

    if ($query->is_main_query() && $query->is_home()) {
        $query->set('cat', '4');
    }
}

/** set some default admin options for dp-dashboard */
if (!function_exists('custom_dp_dashboard')):

    function custom_dp_dashboard() {

        $defaults = get_option('dp_dashboard');

        $new = array(
            /** admin background image */
            'background_image' => NULL,
            /** admin logo */
            'banner_image' => NULL,
            /** custom css url */
            'custom_css_url' => get_template_directory_uri() . '/dp-admin.css',
            /** set the default theme */
            'theme' => 'base',
        );

        $options = wp_parse_args($new, $defaults);

        update_option('dp_dashboard', $options);
    }

endif;



/**
 * -------------------------------------------------------------
 */

//load timber functions
$timber_functions = get_template_directory() . '/timber-functions.php';
if (file_exists($timber_functions))
    include_once $timber_functions;


/**
 * -------------------------------------------------------------
 */
//load custom_functions.php : place your child theme functions in this file
$cusom_functions = get_stylesheet_directory() . '/custom_functions.php';
if (file_exists($cusom_functions))
    include_once $custom_functions;