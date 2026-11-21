<?php
/**
 * Theme setup and rendering helpers.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/inc/customizer.php';
require_once __DIR__ . '/inc/content.php';

function daev_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
}
add_action( 'after_setup_theme', 'daev_setup' );

function daev_enqueue_assets() {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'daev-fonts', get_theme_file_uri( 'assets/css/fonts.css' ), array(), $version );
	wp_enqueue_style( 'daev-site', get_theme_file_uri( 'assets/css/site.css' ), array( 'daev-fonts' ), $version );
	wp_enqueue_script( 'daev-site', get_theme_file_uri( 'assets/js/site.js' ), array(), $version, array( 'strategy' => 'defer', 'in_footer' => true ) );
}
add_action( 'wp_enqueue_scripts', 'daev_enqueue_assets' );

function daev_home_anchor( $id ) {
	return home_url( '/' ) . '#' . $id;
}

function daev_phone_url() {
	$phone = daev_setting( 'phone' );
	$digits = preg_replace( '/\D/', '', $phone );
	return $digits ? 'tel:' . ( str_starts_with( trim( $phone ), '+' ) ? '+' : '' ) . $digits : '';
}

function daev_lines( $text ) {
	return nl2br( esc_html( $text ), false );
}

function daev_paragraphs( $text ) {
	return wpautop( esc_html( $text ) );
}

function daev_bundled_image( $name ) {
	return get_theme_file_uri( 'assets/images/' . $name . '.webp' );
}

function daev_image_id( $setting ) {
	$id = absint( daev_setting( $setting ) );
	return wp_attachment_is_image( $id ) ? $id : 0;
}

function daev_description() {
	if ( is_front_page() ) {
		$text = daev_setting( 'hero_copy' );
	} elseif ( is_singular( array( 'daev_work', 'daev_service' ) ) && ! post_password_required( get_queried_object_id() ) ) {
		$text = get_the_excerpt( get_queried_object_id() );
	} else {
		return;
	}
	$text = wp_trim_words( wp_strip_all_tags( $text, true ), 34 );
	if ( $text ) {
		echo '<meta name="description" content="' . esc_attr( $text ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'daev_description', 5 );
