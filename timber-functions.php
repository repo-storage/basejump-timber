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
    $twig_base = 'base.twig';
    $mobile = new Mobile_Detect();

    /* this is where you can add your own data to Timber's context object */
    $data['foo'] = 'bar';
    $data['theme_url'] = get_stylesheet_directory_uri();
    $data['is_logged_in'] = is_user_logged_in();
    $data['theme_mod'] = get_theme_mods();
    $data['options'] = wp_load_alloptions();
    $data['site_url'] = site_url();
    $data['sidebar'] = Timber::get_widgets('primary-sidebar');
    $data['sidebar_2'] = Timber::get_widgets('sidebar-2');
    $data['info_1'] = Timber::get_widgets('info-1');
    $data['info_2'] = Timber::get_widgets('info-2');
    $data['info_3'] = Timber::get_widgets('info-3');
    $data['info_4'] = Timber::get_widgets('info-4');
    $data['is_home'] = is_home();


    if ($mobile->isMobile()):

        /**
         * mobile twig baase template
         */
        if (file_exists(trailingslashit(get_template_directory()) . 'views/mobile/mobile.twig'))
            $twig_base = 'mobile/mobile-base.twig';

        if($mobile->isTablet() AND file_exists(trailingslashit(get_template_directory()) . 'views/mobile/tablet.twig'))
                $twig_base = 'mobile/tablet.twig';

        /**
         * some variables for mobile
         * {{ mobile.tablet }}
         * {% if mobile.tablet %}do something{% emdif %}
         */
        $mobile['is_mobile'] = true;
        $mobile['tablet'] = $mobile->isTablet();
        $mobile['android'] = $mobile->isAndroidOS();
        $mobile['ios'] = $mobile->isiOS();
        $mobile['iphone'] = $mobile->isiPhone();
        $mobile['ipad'] = $mobile->isiPad();
        $data['mobile'] = $mobile;
    endif;


    //pico theme variables converted to wordpress
    $data['config'] = get_theme_mods();
    $data['base_dir'] = WP_CONTENT_DIR;
    $data['base_url'] = get_bloginfo('wpurl');
    $data['theme_dir'] = get_stylesheet_directory();
    $data['site_title'] = get_bloginfo('name');
    $data['site_description'] = get_bloginfo('description');
    $data['sample_widget'] = 'Please go to -- Admin > Apperance widgets and place any widgets you want to appear on your home page here';
    $data['meta'] = '';
    $data['pages'] = '';
    $data['is_front_page'] = is_front_page();
    $data['base_twig'] = $twig_base;
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

function header_styles() {
    ob_start()
    ?>
    <link rel="shortcut icon" href="<?php echo Theme_Function::file_uri('images/favicon.ico'); ?>">
    <?php if (mod_mobile::detect()->isIphone()): ?>
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
    <?php endif ?>

    <link rel="stylesheet" href="<?php echo Theme_Function::file_uri('assets/bootstrap/css/bootstrap.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo Theme_Function::file_uri('assets/fonts/font-awesome/css/font-awesome.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo Theme_Function::file_uri('assets/fonts/open-sans/stylesheet.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo Theme_Function::file_uri('assets/stylesheet.css'); ?>"/>

    <?php
    return ob_get_clean();
}

function timber_widgets($index = 'primary-sidebar') {
    ob_start();
    dynamic_sidebar($index);
    return ob_get_clean();
}
