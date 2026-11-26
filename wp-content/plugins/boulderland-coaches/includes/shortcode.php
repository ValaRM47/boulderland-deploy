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
function blcc_coach_icon( $k ) {
	$icons = array(
		'certs'     => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="9" r="6"/><path d="M8.5 13.5 7 22l5-3 5 3-1.5-8.5"/></svg>',
		'education' => '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 9l9-4 9 4-9 4z"/><path d="M7 11v4.5c0 1.2 2.5 2.5 5 2.5s5-1.3 5-2.5V11"/><path d="M21 9v4"/></svg>',
		'schedule'  => '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg>',
	);
	return isset( $icons[ $k ] ) ? $icons[ $k ] : '';
}

/** One info row (icon + label + value); returns '' when the value is empty so nothing shows. */
function blcc_coach_row( $key, $label, $value, $allow_br = false ) {
	$plain = trim( wp_strip_all_tags( (string) $value ) );
	if ( '' === $plain ) {
		return '';
	}
	$val = $allow_br ? wp_kses( $value, array( 'br' => array() ) ) : esc_html( $value );
	return '<div class="blcc-row">'
		. '<span class="blcc-ico">' . blcc_coach_icon( $key ) . '</span>'
		. '<div class="blcc-rt"><span class="k">' . esc_html( $label ) . '</span><span class="v">' . $val . '</span></div>'
		. '</div>';
}

function blcc_coach_card_html( $id ) {
	$name      = get_the_title( $id );
	$photo     = blcc_photo_url( $id );
	$specialty = (string) blcc_get( $id, 'blcc_specialty', '' );
	$certs     = (string) blcc_get( $id, 'blcc_certs', '' );
	$education = (string) blcc_get( $id, 'blcc_education', '' );
	$schedule  = (string) blcc_get( $id, 'blcc_schedule', '' );

	$rows  = blcc_coach_row( 'certs', 'گواهینامه‌ها', $certs, true );
	$rows .= blcc_coach_row( 'education', 'تحصیلات', $education );
	$rows .= blcc_coach_row( 'schedule', 'زمان حضور', $schedule, true );

	$photo_html = $photo
		? '<img src="' . esc_url( $photo ) . '" alt="' . esc_attr( $name ) . '" loading="lazy" />'
		: '<div class="blcc-noimg"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg></div>';

	$spec_html = '' !== trim( $specialty ) ? '<span class="blcc-spec">' . esc_html( $specialty ) . '</span>' : '';
	$rows_html = '' !== $rows ? '<div class="blcc-rows">' . $rows . '</div>' : '';

	return '<article class="blcc-card">'
		. '<div class="blcc-photo">' . $photo_html . '</div>'
		. '<div class="blcc-info">'
			. '<div class="blcc-head"><h3 class="blcc-name">' . esc_html( $name ) . '</h3>' . $spec_html . '</div>'
			. $rows_html
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
