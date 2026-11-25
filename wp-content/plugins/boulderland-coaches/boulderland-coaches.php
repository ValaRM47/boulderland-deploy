<?php
/**
 * Plugin Name:       Boulderland Coaches
 * Description:        مربیان بلدرلند — کارت مربیان با عکس و اطلاعات (نام، تخصص، تحصیلات، زمان‌های حضور). فیلدها با ACF، و ترتیب کارت‌ها با کشیدن‌ورها کردن قابل تغییر است.
 * Version:           1.0.0
 * Author:            Boulderland
 * Text Domain:       boulderland-coaches
 * Requires at least: 6.0
 * Requires PHP:      7.4
 *
 * Recommended companion: Advanced Custom Fields (ACF) — the coach fields appear
 * automatically once ACF is active (the free version is enough).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BLCC_VER', '1.0.0' );
define( 'BLCC_DIR', plugin_dir_path( __FILE__ ) );
define( 'BLCC_URL', plugin_dir_url( __FILE__ ) );

/**
 * Read a coach field. Prefers ACF (get_field), falls back to post meta, and
 * returns a plain string for image fields. Prefixed blcc_ so it never clashes
 * with the Boulderland Courses plugin.
 */
function blcc_get( $post_id, $name, $default = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$v = get_field( $name, $post_id );
		if ( null !== $v && '' !== $v ) {
			return $v;
		}
	}
	$v = get_post_meta( $post_id, $name, true );
	return ( '' === $v || null === $v ) ? $default : $v;
}

/** Resolve a coach photo to a URL (ACF image url, attachment id, or featured image). */
function blcc_photo_url( $post_id ) {
	$photo = blcc_get( $post_id, 'blcc_photo', '' );
	if ( is_array( $photo ) ) {
		$photo = isset( $photo['url'] ) ? $photo['url'] : '';
	}
	if ( is_numeric( $photo ) ) {
		$photo = wp_get_attachment_image_url( (int) $photo, 'large' );
	}
	if ( ! $photo ) {
		$thumb = get_the_post_thumbnail_url( $post_id, 'large' );
		if ( $thumb ) {
			$photo = $thumb;
		}
	}
	return (string) $photo;
}

require_once BLCC_DIR . 'includes/cpt.php';
require_once BLCC_DIR . 'includes/acf-fields.php';
require_once BLCC_DIR . 'includes/reorder.php';
require_once BLCC_DIR . 'includes/rest.php';
require_once BLCC_DIR . 'includes/shortcode.php';

register_activation_hook(
	__FILE__,
	function () {
		blcc_register_cpt();
		flush_rewrite_rules();
	}
);
register_deactivation_hook(
	__FILE__,
	function () {
		flush_rewrite_rules();
	}
);
