<?php
/** 
 * Template Name: Home Template 
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
*/

$context = Timber::get_context();

$post = new TimberPost();
$context['post'] = $post;

Timber::render( 'home.twig', $context );
