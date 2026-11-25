<?php
/** Coaches custom post type. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'blcc_register_cpt' );

function blcc_register_cpt() {
	register_post_type(
		'blcc_coach',
		array(
			'labels'       => array(
				'name'          => 'مربیان',
				'singular_name' => 'مربی',
				'menu_name'     => 'مربیان',
				'add_new'       => 'مربی جدید',
				'add_new_item'  => 'افزودن مربی',
				'edit_item'     => 'ویرایش مربی',
				'new_item'      => 'مربی جدید',
				'all_items'     => 'همه‌ی مربیان',
				'search_items'  => 'جستجوی مربی',
				'not_found'     => 'مربی‌ای یافت نشد',
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => false,
			'menu_icon'    => 'dashicons-groups',
			'menu_position'=> 25,
			// title = نام مربی · page-attributes = ترتیب نمایش · thumbnail = عکس (fallback)
			'supports'     => array( 'title', 'page-attributes', 'thumbnail' ),
			'rewrite'      => array( 'slug' => 'coach' ),
		)
	);
}
