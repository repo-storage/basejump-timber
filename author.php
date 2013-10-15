<?php
/**
 * The template for displaying Author Archive pages
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */
global $wp_query;

$data = Timber::get_context();
$post = Timber::get_posts();
$data['posts'] = $post;
$author = new TimberUser($wp_query->query_vars['author']);
$data['author'] = $author;
$data['title'] = 'Author Archives: ' . $author->name();
$templates = array('author-'.$author->slug().'.twig','author-'.$post->post_author.'.twig','author.twig', 'archive.twig');
Timber::render($templates, $data);
