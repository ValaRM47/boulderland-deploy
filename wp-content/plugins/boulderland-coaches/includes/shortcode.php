<?php
/**
 * [boulderland_coaches] — renders the coach cards (photo on one side, info on the other).
 * For use on a WordPress page. The standalone مربیان بلدرلند page pulls the same data
 * from the REST endpoint instead.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'boulderland_coaches', 'blcc_shortcode' );

/** Shared card markup, used by the shortcode (the static page mirrors this in JS). */
function blcc_coach_card_html( $id ) {
	$name      = get_the_title( $id );
	$photo     = blcc_photo_url( $id );
	$specialty = (string) blcc_get( $id, 'blcc_specialty', '' );
	$education = (string) blcc_get( $id, 'blcc_education', '' );
	$schedule  = (string) blcc_get( $id, 'blcc_schedule', '' );

	$rows = '';
	if ( '' !== trim( $specialty ) ) {
		$rows .= '<div class="blcc-row"><span class="k">تخصص</span><span class="v">' . esc_html( $specialty ) . '</span></div>';
	}
	if ( '' !== trim( $education ) ) {
		$rows .= '<div class="blcc-row"><span class="k">تحصیلات</span><span class="v">' . esc_html( $education ) . '</span></div>';
	}
	if ( '' !== trim( wp_strip_all_tags( $schedule ) ) ) {
		$rows .= '<div class="blcc-row"><span class="k">زمان‌های حضور</span><span class="v">' . wp_kses( $schedule, array( 'br' => array() ) ) . '</span></div>';
	}

	$photo_html = $photo
		? '<img src="' . esc_url( $photo ) . '" alt="' . esc_attr( $name ) . '" loading="lazy" />'
		: '<div class="blcc-noimg"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg></div>';

	return '<article class="blcc-card">'
		. '<div class="blcc-photo">' . $photo_html . '</div>'
		. '<div class="blcc-info">'
			. '<h3 class="blcc-name">' . esc_html( $name ) . '</h3>'
			. '<div class="blcc-rows">' . $rows . '</div>'
		. '</div>'
		. '</article>';
}

function blcc_shortcode() {
	wp_enqueue_style( 'blcc-coaches', BLCC_URL . 'assets/coaches.css', array(), BLCC_VER );

	$q = new WP_Query(
		array(
			'post_type'      => 'blcc_coach',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		)
	);

	if ( ! $q->have_posts() ) {
		return '<p class="blcc-empty">هنوز مربی‌ای ثبت نشده است.</p>';
	}

	ob_start();
	echo '<div class="blcc-grid">';
	while ( $q->have_posts() ) {
		$q->the_post();
		echo blcc_coach_card_html( get_the_ID() ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
	echo '</div>';
	wp_reset_postdata();
	return ob_get_clean();
}
