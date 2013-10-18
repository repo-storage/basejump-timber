<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package 	WordPress
 * @subpackage 	Timber
 * @since 		Timber 0.1
 */

	if (!class_exists('Timber')){
		echo 'Timber not activated';
	}

	$data = Timber::get_context();
	$data['menu'] = new TimberMenu();
        $home_query = array('posts_per_page' => 3);
	$timber_posts = Timber::get_posts($home_query);
	$data['posts'] = $timber_posts;
        //$data['base_tpl'] = 'base.twig';
	$templates = array('home.twig','index.twig');
        if(detect_mobiles()->isMobile())
            array_unshift ($templates, 'mobile/home.twig');
	Timber::render($templates, $data);
//        var_dump($data['posts']);



