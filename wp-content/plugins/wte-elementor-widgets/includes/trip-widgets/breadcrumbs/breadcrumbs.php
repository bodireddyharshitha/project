<?php
/**
 * Breadcrumb Widget Render.
 *
 * @since 1.3.0
 * @package wptravelengine-elementor-widgets
 */

global $post;
$post_page  = get_option( 'page_for_posts' ); // The ID of the page that displays posts.
$show_front = get_option( 'show_on_front' ); // What to show on the front page.
$home       = get_theme_mod( 'breadcrumb_home_text', __( 'Home', 'wptravelengine-elementor-widgets' ) ); // text for the 'Home' link.
$before     = '<li class="current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">'; // tag before the current crumb.
$after      = '</li>'; // tag after the current crumb.

// Retrieve attributes value form elementor.
$attributes = (object) $attributes;
$separator  = isset( $attributes->{'type'} ) ? $attributes->{'type'} : 'dot';

if ( is_singular( 'trip' ) || 'elementor_library' === get_post_type( $post->ID ) ) {
	$depth = 1;
	echo '<div class="breadcrumb-wrapper" data-separator="' . esc_attr( $separator ) . '">
            <ul id="crumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( home_url() ) . '" itemprop="item"><span itemprop="name">' . esc_html( $home ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" /></li>';
	$depth = 2;
	// Check for destination taxonomy hierarchy.
	$terms = wp_get_post_terms(
		$post->ID,
		'destination',
		array(
			'orderby' => 'parent',
			'order'   => 'DESC',
		)
	);
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) { // Parents terms.
		$ancestors = get_ancestors( $terms[0]->term_id, 'destination' );
		$ancestors = array_reverse( $ancestors );
		foreach ( $ancestors as $ancestor ) {
			$ancestor = get_term( $ancestor, 'destination' );
			if ( ! is_wp_error( $ancestor ) && $ancestor ) {
				echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" /></li>';
			}
			++$depth;
		}
		// Last child term.
		echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_term_link( $terms[0] ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $terms[0]->name ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" /></li>';
		++$depth;
	}
	echo wp_kses_post( $before ) . '<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . wp_kses_post( $after );
	echo '</ul></div><!-- .breadcrumb-wrapper -->';
}
