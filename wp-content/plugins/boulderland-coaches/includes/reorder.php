<?php
/**
 * Reorder coaches by drag-and-drop in the admin list (saves menu_order).
 * The «ترتیب» (Order) field from page-attributes also works as a fallback.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Admin list + REST default to menu_order, and show all coaches on one page so drag covers them all.
add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( is_admin() && $q->is_main_query() && 'blcc_coach' === $q->get( 'post_type' ) ) {
			$q->set( 'orderby', 'menu_order title' );
			$q->set( 'order', 'ASC' );
			$q->set( 'posts_per_page', -1 );
		}
	}
);

// Enqueue jQuery UI sortable + the reorder script on the coaches list screen.
add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		$screen = get_current_screen();
		if ( 'edit.php' !== $hook || ! $screen || 'blcc_coach' !== $screen->post_type ) {
			return;
		}
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_add_inline_script( 'jquery-ui-sortable', blcc_reorder_js() );
		wp_add_inline_style( 'wp-admin', '#the-list tr.ui-sortable-helper{display:table;background:#fff;box-shadow:0 2px 8px rgba(0,0,0,.18)} .wp-list-table.posts tbody#the-list tr{cursor:move}' );
	}
);

function blcc_reorder_js() {
	$ajax  = esc_js( admin_url( 'admin-ajax.php' ) );
	$nonce = esc_js( wp_create_nonce( 'blcc_reorder' ) );
	return "jQuery(function($){
	  var \$list = $('#the-list');
	  if(!\$list.length) return;
	  \$list.sortable({
	    items: 'tr',
	    axis: 'y',
	    cursor: 'move',
	    helper: function(e, tr){
	      var cells = tr.children();
	      var helper = tr.clone();
	      helper.children().each(function(i){ $(this).width(cells.eq(i).width()); });
	      return helper;
	    },
	    update: function(){
	      var ids = [];
	      \$list.find('tr').each(function(){
	        var id = (this.id || '').replace('post-','');
	        if(id) ids.push(id);
	      });
	      $.post('{$ajax}', { action:'blcc_reorder', nonce:'{$nonce}', order:ids });
	    }
	  });
	});";
}

add_action(
	'wp_ajax_blcc_reorder',
	function () {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! current_user_can( 'edit_posts' ) || ! wp_verify_nonce( $nonce, 'blcc_reorder' ) ) {
			wp_send_json_error( array(), 403 );
		}
		$order = isset( $_POST['order'] ) ? array_map( 'absint', (array) $_POST['order'] ) : array();
		foreach ( $order as $i => $id ) {
			if ( $id && 'blcc_coach' === get_post_type( $id ) ) {
				wp_update_post(
					array(
						'ID'         => $id,
						'menu_order' => $i,
					)
				);
			}
		}
		wp_send_json_success();
	}
);
