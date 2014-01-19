<?php

/**
 * BJ functions and definitions
 *
 * @package BJ
 * @since BJ 1.0
 */


/** just icase we need a config file; */
if($bj_config = locate_template('config.php'))
    include_once $bj_config;


// solution for possible missing PHP constants, for WP 3.0 and higher only
// http://codex.wordpress.org/Determining_Plugin_and_Content_Directories

if (!defined('WP_CONTENT_URL')) define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
if (!defined('WP_CONTENT_DIR')) define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
if (!defined('WP_PLUGIN_URL')) define('WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins');
if (!defined('WP_PLUGIN_DIR')) define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
if (!defined('WPMU_PLUGIN_URL')) define('WPMU_PLUGIN_URL', WP_CONTENT_URL. '/mu-plugins');
if (!defined('WPMU_PLUGIN_DIR')) define('WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins');

/**
 * ******************************plugin activations*****************************
 */
if (file_exists(get_template_directory() . '/plugins/theme-plugins.php'))
    include_once get_template_directory() . '/plugins/theme-plugins.php';

/* * **************************************************************************** */



function install_guide($templates) {
    $tpl = get_template_directory() . '/install-guide.php';
    load_template($tpl);
}

if (!class_exists('cwp') OR !class_exists('al_manager') OR !$wp_version > 3.4):
    add_filter('template_include', 'install_guide');
    return;
endif;


/**
 * CSF FUNCTIONS
 */
if (file_exists(WP_PLUGIN_DIR.'/al-manager/vendor/core-wp/csf_functions.php')):
    include_once WP_PLUGIN_DIR.'/al-manager/vendor/core-wp/csf_functions.php';
else:
    if (defined('CWP_PATH') and file_exists(CWP_PATH . '/csf_functions.php'))
        include_once CWP_PATH . '/csf_functions.php';
endif;



/**
 * sudo function
 */
function _bj_layout() {

}

/**
 * ***************THEME OPTIONS *************************************************
 */
if (file_exists(get_template_directory() . '/theme-options.php')):
    include_once get_template_directory() . '/theme-options.php';
endif;


/**
 * ******************************************************************************
 * custom functions create this file and add your own custom functions
 */
if (file_exists(TEMPLATEPATH . '/custom_functions.php')) {
    include_once TEMPLATEPATH . '/custom_functions.php';
}

/**
 * ******************************************************************************
 */
/**
 * ******************************************************************************
 * toolbox functions theme functions
 */
if (file_exists(TEMPLATEPATH . '/theme_functions.php'))
    include_once TEMPLATEPATH . '/theme_functions.php';

/**
 * ******************************************************************************
 */


if (!function_exists('bj_setup')):

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * @since BJ 1.0
     */
    function bj_setup() {

        /**
         * Custom template tags for this theme.
         */
        require( get_template_directory() . '/inc/template-tags.php' );

        /**
         * Custom functions that act independently of the theme templates
         */
        //require( get_template_directory() . '/inc/tweaks.php' );

        /**
         * Custom Theme Options
         */
        //require( get_template_directory() . '/inc/theme-options/theme-options.php' );

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * If you're building a theme based on BJ, use a find and replace
         * to change 'bj' to the name of your theme in all the template files
         */
        load_theme_textdomain('bj', get_template_directory() . '/languages');
    }

endif; // bj_setup
add_action('after_setup_theme', 'bj_setup');

/**
 * Enqueue scripts and styles
 */
function bj_scripts() {
    global $post;

    //wp_enqueue_style( 'style', get_stylesheet_uri() );
    //wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_singular() && wp_attachment_is_image($post->ID)) {
        wp_enqueue_script('keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20120202');
    }
}

add_action('wp_enqueue_scripts', 'bj_scripts');

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

