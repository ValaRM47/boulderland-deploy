<?php
/** ACF local field group for coaches (registered in code — appears automatically once ACF is active). */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'blcc_register_acf' );

function blcc_register_acf() {

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'             => 'group_blcc_coach',
			'title'           => 'مشخصات مربی',
			'fields'          => array(
				array(
					'key'           => 'field_blcc_photo',
					'label'         => 'عکس مربی',
					'name'          => 'blcc_photo',
					'type'          => 'image',
					'return_format' => 'url',
					'preview_size'  => 'medium',
					'library'       => 'all',
					'mime_types'    => 'jpg,jpeg,png,webp',
					'instructions'  => 'ترجیحاً عکس عمودی (پرتره).',
				),
				array(
					'key'   => 'field_blcc_specialty',
					'label' => 'تخصص',
					'name'  => 'blcc_specialty',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_blcc_education',
					'label' => 'تحصیلات',
					'name'  => 'blcc_education',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_blcc_schedule',
					'label'        => 'زمان‌های حضور',
					'name'         => 'blcc_schedule',
					'type'         => 'textarea',
					'rows'         => 3,
					'new_lines'    => 'br',
					'instructions' => 'هر زمان را در یک خط بنویسید.',
				),
			),
			'location'        => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'blcc_coach',
					),
				),
			),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'hide_on_screen'  => array( 'the_content' ),
			'description'     => 'فیلدهای مربی بلدرلند (افزونه‌ی مربیان).',
		)
	);
}
