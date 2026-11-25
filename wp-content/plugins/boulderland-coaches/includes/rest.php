<?php
/**
 * REST API so the static مربیان بلدرلند page can list coaches:
 *   GET /wp-json/blc-coaches/v1/coaches  -> published coaches (ordered), as JSON.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'blc-coaches/v1',
			'/coaches',
			array(
				'methods'             => 'GET',
				'permission_callback' => '__return_true',
				'callback'            => 'blcc_rest_coaches',
			)
		);
	}
);

function blcc_rest_coaches() {
	$q   = new WP_Query(
		array(
			'post_type'      => 'blcc_coach',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'no_found_rows'  => true,
		)
	);
	$out = array();
	foreach ( $q->posts as $p ) {
		$id    = $p->ID;
		$out[] = array(
			'id'        => (int) $id,
			'name'      => get_the_title( $id ),
			'specialty' => (string) blcc_get( $id, 'blcc_specialty', '' ),
			'certs'     => (string) blcc_get( $id, 'blcc_certs', '' ),
			'education' => (string) blcc_get( $id, 'blcc_education', '' ),
			'schedule'  => (string) blcc_get( $id, 'blcc_schedule', '' ),
			'photo'     => blcc_photo_url( $id ),
		);
	}
	return rest_ensure_response( $out );
}
